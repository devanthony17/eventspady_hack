import { useState, useEffect } from 'react'
import { useParams, Link } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import api from '../api/api'

export default function OrganizerDetail() {
  const { id } = useParams()
  const { isLoggedIn } = useAuth()
  const [data, setData] = useState(null)
  const [loading, setLoading] = useState(true)
  const [following, setFollowing] = useState(false)
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    if (!isLoggedIn) {
      // For unauthenticated, try to get basic organizer info from home data
      api.get('/frontend/home').then((r) => {
        const orgs = r.data?.data?.organizers || []
        const org = orgs.find((o) => String(o.id) === String(id))
        setData({ organizer: org, events: [] })
      }).finally(() => setLoading(false))
    } else {
      api.get(`/user/organization-detail/${id}`)
        .then((r) => setData(r.data?.data || null))
        .finally(() => setLoading(false))
    }
  }, [id, isLoggedIn])

  const handleFollow = () => {
    api.post('/user/add-following-list', { organization_id: id })
      .then(() => setFollowing(!following))
      .catch(() => {})
  }

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>
  if (!data?.organizer) return (
    <div className="page-container">
      <div className="empty-state"><div className="empty-state-icon">😕</div><h3>Organizer not found</h3><Link to="/" className="btn btn-primary" style={{ marginTop:'1rem' }}>Go Home</Link></div>
    </div>
  )

  const { organizer, events = [] } = data

  return (
    <div className="page-container">
      {/* Profile header */}
      <div style={{ background:'var(--bg-card)', border:'1px solid var(--border)', borderRadius:'var(--radius)', padding:'2rem', marginBottom:'2rem', display:'flex', gap:'1.5rem', alignItems:'flex-start', flexWrap:'wrap' }}>
        <img
          src={organizer.image ? `${imgBase}${organizer.image}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(organizer.name)}&size=100&background=6c63ff&color=fff`}
          alt={organizer.name}
          style={{ width:100, height:100, borderRadius:'50%', objectFit:'cover', border:'3px solid var(--primary)' }}
        />
        <div style={{ flex:1 }}>
          <h1 style={{ fontSize:'1.6rem', fontWeight:800, marginBottom:'0.25rem' }}>{organizer.name}</h1>
          <p style={{ color:'var(--text-muted)', fontSize:'0.9rem', marginBottom:'0.75rem' }}>{organizer.email}</p>
          {organizer.about && <p style={{ color:'var(--text-muted)', fontSize:'0.875rem', lineHeight:1.7 }}>{organizer.about}</p>}
        </div>
        {isLoggedIn && (
          <button className={`btn ${following ? 'btn-ghost' : 'btn-primary'}`} onClick={handleFollow}>
            {following ? '✓ Following' : '+ Follow'}
          </button>
        )}
      </div>

      {/* Organizer's events */}
      {events.length > 0 && (
        <>
          <h2 className="section-title">Events by <span>{organizer.name}</span></h2>
          <div className="grid-3">
            {events.map((item) => {
              const slug = item.name?.replace(/\s+/g, '-').toLowerCase()
              return (
                <div key={item.id} className="card">
                  <img src={`${imgBase}${item.image}`} alt={item.name} className="card-img" />
                  <div className="card-body">
                    <div className="card-title"><Link to={`/event/${item.id}/${slug}`}>{item.name}</Link></div>
                    <div className="card-meta">
                      <span className="badge accent">📅 {new Date(item.start_time).toLocaleDateString()}</span>
                    </div>
                    <Link to={`/event/${item.id}/${slug}`} className="btn btn-primary" style={{ width:'100%' }}>View Event</Link>
                  </div>
                </div>
              )
            })}
          </div>
        </>
      )}
    </div>
  )
}
