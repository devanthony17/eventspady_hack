import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import api from '../api/api'

const STATUS_COLOR = {
  pending: 'var(--warning)',
  confirmed: 'var(--success)',
  cancelled: 'var(--danger)',
}

export default function MyTickets() {
  const [orders, setOrders] = useState([])
  const [loading, setLoading] = useState(true)
  const [selected, setSelected] = useState(null) // order detail modal

  useEffect(() => {
    api.get('/user/view-all-tickets').then((r) => setOrders(r.data?.data || [])).finally(() => setLoading(false))
  }, [])

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>

  return (
    <div className="page-container">
      <div className="page-header">
        <h1>My Tickets</h1>
        <p>All your booked event tickets in one place</p>
      </div>

      {orders.length === 0 ? (
        <div className="empty-state">
          <div className="empty-state-icon">🎟</div>
          <h3>No tickets yet</h3>
          <p>You haven't booked any events. Start exploring!</p>
          <Link to="/events" className="btn btn-primary" style={{ marginTop: '1rem' }}>Browse Events</Link>
        </div>
      ) : (
        <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
          {orders.map((order) => (
            <div key={order.id} className="card" style={{ flexDirection: 'row', display: 'flex', gap: '1.25rem', padding: '1.25rem', alignItems: 'center', flexWrap: 'wrap' }}>
              {/* Event image */}
              {order.event?.image && (
                <img
                  src={`http://localhost:8000/images/upload/${order.event.image}`}
                  alt={order.event?.name}
                  style={{ width: 90, height: 70, objectFit: 'cover', borderRadius: 'var(--radius-sm)', flexShrink: 0 }}
                />
              )}

              {/* Info */}
              <div style={{ flex: 1, minWidth: 0 }}>
                <h3 style={{ fontWeight: 700, fontSize: '1rem', marginBottom: '0.3rem', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>
                  {order.event?.name || 'Event'}
                </h3>
                <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.75rem', fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                  {order.event?.start_time && (
                    <span>📅 {new Date(order.event.start_time).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' })}</span>
                  )}
                  <span>🎟 {order.quantity} ticket{order.quantity !== 1 ? 's' : ''}</span>
                  <span>💰 ${order.total_price || order.amount || '0.00'}</span>
                </div>
              </div>

              {/* Status + actions */}
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', flexShrink: 0 }}>
                <span style={{
                  padding: '0.25rem 0.75rem',
                  borderRadius: '40px',
                  fontSize: '0.75rem',
                  fontWeight: 700,
                  background: `${STATUS_COLOR[order.status?.toLowerCase()] || 'var(--primary)'}22`,
                  color: STATUS_COLOR[order.status?.toLowerCase()] || 'var(--primary)',
                  textTransform: 'capitalize',
                }}>
                  {order.status || 'Pending'}
                </span>
                <button
                  className="btn btn-ghost"
                  style={{ padding: '0.35rem 0.9rem', fontSize: '0.8rem' }}
                  onClick={() => setSelected(order)}
                >
                  View
                </button>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* Simple detail modal */}
      {selected && (
        <div
          style={{ position: 'fixed', inset: 0, background: 'rgba(0,0,0,0.7)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 9999, padding: '1rem' }}
          onClick={() => setSelected(null)}
        >
          <div
            style={{ background: 'var(--bg-card)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', padding: '2rem', maxWidth: 480, width: '100%', maxHeight: '80vh', overflowY: 'auto' }}
            onClick={(e) => e.stopPropagation()}
          >
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.25rem' }}>
              <h2 style={{ fontWeight: 800, fontSize: '1.1rem' }}>Ticket Details</h2>
              <button onClick={() => setSelected(null)} style={{ color: 'var(--text-muted)', fontSize: '1.2rem' }}>✕</button>
            </div>

            <p style={{ color: 'var(--text-muted)', fontSize: '0.8rem', marginBottom: '0.25rem' }}>EVENT</p>
            <p style={{ fontWeight: 700, marginBottom: '1rem' }}>{selected.event?.name}</p>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '1.25rem' }}>
              {[
                { label: 'Order ID', value: `#${selected.id}` },
                { label: 'Status', value: selected.status || 'Pending' },
                { label: 'Tickets', value: selected.quantity },
                { label: 'Total', value: `$${selected.total_price || selected.amount || 0}` },
              ].map((r) => (
                <div key={r.label} style={{ background: 'rgba(255,255,255,0.04)', borderRadius: 'var(--radius-sm)', padding: '0.75rem' }}>
                  <p style={{ color: 'var(--text-muted)', fontSize: '0.7rem', marginBottom: '0.2rem', textTransform: 'uppercase' }}>{r.label}</p>
                  <p style={{ fontWeight: 700 }}>{r.value}</p>
                </div>
              ))}
            </div>

            <Link
              to={`/event/${selected.event?.id}`}
              className="btn btn-outline"
              style={{ width: '100%' }}
              onClick={() => setSelected(null)}
            >
              View Event →
            </Link>
          </div>
        </div>
      )}
    </div>
  )
}
