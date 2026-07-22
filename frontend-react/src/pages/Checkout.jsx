import { useState, useEffect } from 'react'
import { useParams, useNavigate, Link } from 'react-router-dom'
import api from '../api/api'

export default function Checkout() {
  const { eventId } = useParams()
  const navigate = useNavigate()
  const [event, setEvent] = useState(null)
  const [tickets, setTickets] = useState([])
  const [tax, setTax] = useState([])
  const [coupons, setCoupons] = useState([])
  const [loading, setLoading] = useState(true)
  const [submitting, setSubmitting] = useState(false)
  const [error, setError] = useState('')
  const [success, setSuccess] = useState('')
  const [couponCode, setCouponCode] = useState('')
  const [discount, setDiscount] = useState(0)
  const [selections, setSelections] = useState({}) // { ticketId: qty }
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    Promise.all([
      api.get(`/user/event-detail/${eventId}`),
      api.get(`/user/event-tickets/${eventId}`),
      api.get(`/user/order-tax/${eventId}`),
      api.get('/user/all-coupon'),
    ]).then(([evRes, tkRes, taxRes, cpRes]) => {
      setEvent(evRes.data?.data)
      const tks = tkRes.data?.data || []
      setTickets(tks)
      setTax(taxRes.data?.data || [])
      setCoupons(cpRes.data?.data || [])
      // Initialize selections to 0
      const init = {}
      tks.forEach((t) => { init[t.id] = 0 })
      setSelections(init)
    }).finally(() => setLoading(false))
  }, [eventId])

  const totalBase = tickets.reduce((sum, t) => sum + (t.price * (selections[t.id] || 0)), 0)
  const totalTax = tax.reduce((sum, tx) => sum + (totalBase * (tx.percentage / 100)), 0)
  const totalQty = Object.values(selections).reduce((a, b) => a + b, 0)
  const grandTotal = Math.max(0, totalBase + totalTax - discount)

  const applyCoupon = () => {
    const c = coupons.find((x) => x.code?.toLowerCase() === couponCode.toLowerCase())
    if (!c) { setError('Coupon not found.'); return }
    const disc = totalBase * (c.discount / 100)
    setDiscount(disc)
    setError('')
  }

  const handleQty = (ticketId, delta) => {
    setSelections((prev) => {
      const next = Math.max(0, (prev[ticketId] || 0) + delta)
      const t = tickets.find((x) => x.id === ticketId)
      if (next > (t?.quantity || 0)) return prev
      return { ...prev, [ticketId]: next }
    })
  }

  const handleOrder = async () => {
    if (totalQty === 0) { setError('Please select at least one ticket.'); return }
    setSubmitting(true)
    setError('')
    try {
      const ticketData = Object.entries(selections)
        .filter(([, qty]) => qty > 0)
        .map(([id, qty]) => ({ ticket_id: id, quantity: qty }))

      await api.post('/user/create-order', {
        event_id: eventId,
        tickets: ticketData,
        coupon_code: couponCode || undefined,
      })
      setSuccess('🎉 Booking confirmed! Check My Tickets for your order.')
    } catch (err) {
      setError(err.response?.data?.message || 'Order failed. Please try again.')
    } finally {
      setSubmitting(false)
    }
  }

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>
  if (!event) return <div className="page-container"><div className="empty-state"><div className="empty-state-icon">😕</div><h3>Event not found</h3><Link to="/events" className="btn btn-primary" style={{ marginTop:'1rem' }}>Browse Events</Link></div></div>

  return (
    <div className="page-container">
      <div style={{ display:'flex', gap:'0.5rem', alignItems:'center', color:'var(--text-muted)', fontSize:'0.875rem', marginBottom:'1.5rem' }}>
        <Link to="/">Home</Link> <span>›</span>
        <Link to={`/event/${event.id}`}>{event.name}</Link> <span>›</span>
        <span style={{ color:'var(--text)' }}>Checkout</span>
      </div>

      <h1 style={{ fontSize:'1.75rem', fontWeight:800, marginBottom:'2rem' }}>Complete Your Booking</h1>

      {success ? (
        <div style={{ textAlign:'center', padding:'3rem' }}>
          <div style={{ fontSize:'3.5rem', marginBottom:'1rem' }}>🎉</div>
          <div className="alert alert-success" style={{ display:'inline-flex', fontSize:'1rem' }}>{success}</div>
          <div style={{ display:'flex', gap:'1rem', justifyContent:'center', marginTop:'1.5rem' }}>
            <Link to="/my-tickets" className="btn btn-primary">View My Tickets</Link>
            <Link to="/events" className="btn btn-ghost">Browse More Events</Link>
          </div>
        </div>
      ) : (
        <div style={{ display:'grid', gridTemplateColumns:'1fr 360px', gap:'2rem', alignItems:'start' }}>
          {/* Left — ticket selector */}
          <div>
            <div style={{ background:'var(--bg-card)', border:'1px solid var(--border)', borderRadius:'var(--radius)', overflow:'hidden', marginBottom:'1.5rem' }}>
              <img src={`${imgBase}${event.image}`} alt={event.name} style={{ width:'100%', height:220, objectFit:'cover' }} />
              <div style={{ padding:'1.25rem' }}>
                <h2 style={{ fontWeight:700, marginBottom:'0.5rem' }}>{event.name}</h2>
                <p style={{ color:'var(--text-muted)', fontSize:'0.875rem' }}>
                  📅 {new Date(event.start_time).toLocaleDateString('en-US',{weekday:'long',day:'numeric',month:'long',year:'numeric'})}
                </p>
              </div>
            </div>

            <h3 style={{ fontWeight:700, marginBottom:'1rem', fontSize:'1rem' }}>Select Tickets</h3>
            {error && <div className="alert alert-error">{error}</div>}

            {tickets.map((t) => (
              <div key={t.id} style={{ background:'var(--bg-card)', border:'1px solid var(--border)', borderRadius:'var(--radius-sm)', padding:'1.1rem', marginBottom:'0.75rem', display:'flex', justifyContent:'space-between', alignItems:'center' }}>
                <div>
                  <p style={{ fontWeight:600 }}>{t.name}</p>
                  <p style={{ fontSize:'0.8rem', color:'var(--text-muted)' }}>{t.description}</p>
                  <p style={{ color:'var(--primary)', fontWeight:700, marginTop:'0.25rem' }}>
                    {t.price == 0 ? 'Free' : `$${t.price}`}
                  </p>
                  <p style={{ fontSize:'0.75rem', color: t.quantity > 0 ? 'var(--success)' : 'var(--danger)' }}>
                    {t.quantity > 0 ? `${t.quantity} available` : 'Sold out'}
                  </p>
                </div>
                <div style={{ display:'flex', alignItems:'center', gap:'0.75rem' }}>
                  <button className="btn btn-ghost" style={{ padding:'0.3rem 0.75rem', fontSize:'1.1rem' }} onClick={() => handleQty(t.id, -1)} disabled={selections[t.id] === 0}>−</button>
                  <span style={{ fontWeight:700, minWidth:24, textAlign:'center' }}>{selections[t.id] || 0}</span>
                  <button className="btn btn-ghost" style={{ padding:'0.3rem 0.75rem', fontSize:'1.1rem' }} onClick={() => handleQty(t.id, 1)} disabled={t.quantity === 0}>+</button>
                </div>
              </div>
            ))}

            {/* Coupon */}
            <div style={{ display:'flex', gap:'0.75rem', marginTop:'1rem' }}>
              <input type="text" className="form-control" placeholder="Coupon code" value={couponCode} onChange={(e) => setCouponCode(e.target.value)} style={{ flex:1 }} />
              <button className="btn btn-outline" onClick={applyCoupon} style={{ flexShrink:0 }}>Apply</button>
            </div>
          </div>

          {/* Right — order summary */}
          <div style={{ position:'sticky', top:140 }}>
            <div style={{ background:'var(--bg-card)', border:'1px solid var(--border)', borderRadius:'var(--radius)', padding:'1.5rem' }}>
              <h3 style={{ fontWeight:700, marginBottom:'1.25rem' }}>Order Summary</h3>

              {tickets.filter((t) => (selections[t.id] || 0) > 0).length === 0 ? (
                <p style={{ color:'var(--text-muted)', fontSize:'0.875rem' }}>No tickets selected yet.</p>
              ) : (
                <div style={{ marginBottom:'1rem' }}>
                  {tickets.filter((t) => (selections[t.id] || 0) > 0).map((t) => (
                    <div key={t.id} style={{ display:'flex', justifyContent:'space-between', fontSize:'0.875rem', marginBottom:'0.5rem' }}>
                      <span>{t.name} × {selections[t.id]}</span>
                      <span>${(t.price * selections[t.id]).toFixed(2)}</span>
                    </div>
                  ))}
                </div>
              )}

              <div style={{ borderTop:'1px solid var(--border)', paddingTop:'1rem', display:'flex', flexDirection:'column', gap:'0.5rem', fontSize:'0.875rem' }}>
                <div style={{ display:'flex', justifyContent:'space-between' }}>
                  <span style={{ color:'var(--text-muted)' }}>Subtotal</span>
                  <span>${totalBase.toFixed(2)}</span>
                </div>
                {totalTax > 0 && (
                  <div style={{ display:'flex', justifyContent:'space-between' }}>
                    <span style={{ color:'var(--text-muted)' }}>Tax</span>
                    <span>${totalTax.toFixed(2)}</span>
                  </div>
                )}
                {discount > 0 && (
                  <div style={{ display:'flex', justifyContent:'space-between', color:'var(--success)' }}>
                    <span>Discount</span>
                    <span>−${discount.toFixed(2)}</span>
                  </div>
                )}
                <div style={{ display:'flex', justifyContent:'space-between', fontWeight:700, fontSize:'1rem', marginTop:'0.5rem', paddingTop:'0.5rem', borderTop:'1px solid var(--border)' }}>
                  <span>Total</span>
                  <span style={{ color:'var(--primary)' }}>${grandTotal.toFixed(2)}</span>
                </div>
              </div>

              <button
                className="btn btn-primary"
                style={{ width:'100%', marginTop:'1.5rem', padding:'0.8rem' }}
                onClick={handleOrder}
                disabled={submitting || totalQty === 0}
              >
                {submitting ? 'Processing…' : `Confirm Booking • $${grandTotal.toFixed(2)}`}
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}
