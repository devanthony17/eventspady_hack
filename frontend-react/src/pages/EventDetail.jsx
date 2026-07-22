import { useState, useEffect } from 'react'
import { useParams, Link, useNavigate } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import api from '../api/api'

export default function EventDetail() {
  const { id } = useParams()
  const [event, setEvent] = useState(null)
  const [tickets, setTickets] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')
  const { isLoggedIn } = useAuth()
  const navigate = useNavigate()
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    setLoading(true)
    Promise.all([
      api.get(`/user/event-detail/${id}`),
      api.get(`/user/event-tickets/${id}`),
    ])
      .then(([evRes, tkRes]) => {
        setEvent(evRes.data?.data || null)
        setTickets(tkRes.data?.data || [])
      })
      .catch(() => setError('Event not found.'))
      .finally(() => setLoading(false))
  }, [id])

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>
  if (error || !event) return (
    <div className="page-container">
      <div className="empty-state"><div className="empty-state-icon">😕</div><h3>{error || 'Event not found'}</h3><Link to="/events" className="btn btn-primary" style={{ marginTop:'1rem' }}>Back to Events</Link></div>
    </div>
  )

  const fmtDate = (d) => new Date(d).toLocaleDateString('en-US', { weekday:'long', day:'numeric', month:'long', year:'numeric', hour:'2-digit', minute:'2-digit' })

  return (
    <div className="page-container">
      {/* Breadcrumb */}
      <div style={{ display:'flex', gap:'0.5rem', alignItems:'center', color:'var(--text-muted)', fontSize:'0.875rem', marginBottom:'1.5rem' }}>
        <Link to="/">Home</Link> <span>›</span>
        <Link to="/events">Events</Link> <span>›</span>
        <span style={{ color:'var(--text)' }}>{event.name}</span>
      </div>

      <div style={{ display:'grid', gridTemplateColumns:'1fr 340px', gap:'2rem', alignItems:'start' }}>
        {/* Left — main content */}
        <div>
          <div style={{ borderRadius:'var(--radius)', overflow:'hidden', marginBottom:'2rem', position:'relative' }}>
            <img src={`${imgBase}${event.image}`} alt={event.name} style={{ width:'100%', maxHeight:440, objectFit:'cover' }} />
            <span className="badge" style={{ position:'absolute', top:16, left:16, fontSize:'0.85rem' }}>{event.category?.name}</span>
          </div>

          <h1 style={{ fontSize:'2rem', fontWeight:800, marginBottom:'1rem' }}>{event.name}</h1>

          <div style={{ display:'flex', flexWrap:'wrap', gap:'1rem', marginBottom:'1.5rem' }}>
            <div style={{ display:'flex', alignItems:'center', gap:'0.4rem', color:'var(--text-muted)', fontSize:'0.9rem' }}>
              📅 <span>{fmtDate(event.start_time)}</span>
            </div>
            <div style={{ display:'flex', alignItems:'center', gap:'0.4rem', color:'var(--text-muted)', fontSize:'0.9rem' }}>
              🏁 <span>Ends: {fmtDate(event.end_time)}</span>
            </div>
            {event.location && (
              <div style={{ display:'flex', alignItems:'center', gap:'0.4rem', color:'var(--text-muted)', fontSize:'0.9rem' }}>
                📍 <span>{event.location}</span>
              </div>
            )}
          </div>

          {/* Stats row */}
          <div style={{ display:'grid', gridTemplateColumns:'repeat(auto-fit, minmax(120px, 1fr))', gap:'1rem', marginBottom:'2rem' }}>
            {[
              { label:'Capacity', value:`${event.people} people`, icon:'👥' },
              { label:'Tickets Sold', value:`${event.sold_ticket}`, icon:'🎟' },
              { label:'Available', value:`${event.available_ticket}`, icon:'✅' },
            ].map((s) => (
              <div key={s.label} style={{ background:'var(--bg-card)', border:'1px solid var(--border)', borderRadius:'var(--radius-sm)', padding:'1rem', textAlign:'center' }}>
                <div style={{ fontSize:'1.5rem' }}>{s.icon}</div>
                <div style={{ fontWeight:700, fontSize:'1.1rem' }}>{s.value}</div>
                <div style={{ color:'var(--text-muted)', fontSize:'0.75rem' }}>{s.label}</div>
              </div>
            ))}
          </div>

          {/* Description */}
          {event.description && (
            <div style={{ marginBottom:'2rem' }}>
              <h2 style={{ fontSize:'1.1rem', fontWeight:700, marginBottom:'0.75rem' }}>About this Event</h2>
              <div style={{ color:'var(--text-muted)', lineHeight:1.8, fontSize:'0.95rem' }} dangerouslySetInnerHTML={{ __html: event.description }} />
            </div>
          )}

          {/* Gallery */}
          {event.gallery?.length > 0 && (
            <div style={{ marginBottom:'2rem' }}>
              <h2 style={{ fontSize:'1.1rem', fontWeight:700, marginBottom:'0.75rem' }}>Gallery</h2>
              <div style={{ display:'grid', gridTemplateColumns:'repeat(auto-fill, minmax(150px, 1fr))', gap:'0.5rem' }}>
                {event.gallery.map((g, i) => (
                  <img key={i} src={`${imgBase}${g}`} alt="" style={{ width:'100%', height:110, objectFit:'cover', borderRadius:'var(--radius-sm)' }} />
                ))}
              </div>
            </div>
          )}
        </div>

        {/* Right — booking sidebar */}
        <div style={{ position:'sticky', top: 140 }}>
          <div style={{ background:'var(--bg-card)', border:'1px solid var(--border)', borderRadius:'var(--radius)', padding:'1.5rem' }}>
            <h3 style={{ fontWeight:700, marginBottom:'1.25rem', fontSize:'1.1rem' }}>🎟 Available Tickets</h3>

            {tickets.length ? tickets.map((t) => (
              <div key={t.id} style={{ padding:'1rem', border:'1px solid var(--border)', borderRadius:'var(--radius-sm)', marginBottom:'0.75rem' }}>
                <div style={{ display:'flex', justifyContent:'space-between', alignItems:'center', marginBottom:'0.4rem' }}>
                  <span style={{ fontWeight:600 }}>{t.name}</span>
                  <span style={{ color:'var(--primary)', fontWeight:700 }}>
                    {t.price == 0 ? 'Free' : `$${t.price}`}
                  </span>
                </div>
                {t.description && <p style={{ fontSize:'0.8rem', color:'var(--text-muted)', marginBottom:'0.4rem' }}>{t.description}</p>}
                <p style={{ fontSize:'0.75rem', color: t.quantity > 0 ? 'var(--success)' : 'var(--danger)' }}>
                  {t.quantity > 0 ? `${t.quantity} remaining` : 'Sold out'}
                </p>
              </div>
            )) : (
              <p style={{ color:'var(--text-muted)', fontSize:'0.875rem' }}>No tickets available.</p>
            )}

            {event.available_ticket > 0 ? (
              isLoggedIn ? (
                <Link to={`/checkout/${event.id}`} className="btn btn-primary" style={{ width:'100%', marginTop:'1rem' }}>
                  Book Now 🎟
                </Link>
              ) : (
                <Link to="/login" state={{ from: `/checkout/${event.id}` }} className="btn btn-primary" style={{ width:'100%', marginTop:'1rem' }}>
                  Sign in to Book
                </Link>
              )
            ) : (
              <button className="btn btn-ghost" disabled style={{ width:'100%', marginTop:'1rem' }}>Sold Out</button>
            )}

            {/* Organizer */}
            {event.user && (
              <div style={{ marginTop:'1.25rem', paddingTop:'1.25rem', borderTop:'1px solid var(--border)' }}>
                <p style={{ fontSize:'0.75rem', color:'var(--text-muted)', marginBottom:'0.5rem' }}>ORGANIZER</p>
                <Link to={`/organizer/${event.user.id}`} style={{ display:'flex', alignItems:'center', gap:'0.75rem' }}>
                  <img
                    src={event.user.image ? `${imgBase}${event.user.image}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(event.user.name)}&background=6c63ff&color=fff`}
                    alt={event.user.name}
                    style={{ width:36, height:36, borderRadius:'50%', objectFit:'cover' }}
                  />
                  <span style={{ fontWeight:600, fontSize:'0.9rem' }}>{event.user.name}</span>
                </Link>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  )
}
