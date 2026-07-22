import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import api from '../api/api'

export default function AllCategories() {
  const [categories, setCategories] = useState([])
  const [loading, setLoading] = useState(true)
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    api.get('/user/category').then((r) => setCategories(r.data?.data || [])).finally(() => setLoading(false))
  }, [])

  return (
    <div className="page-container">
      <div className="page-header">
        <h1>All Categories</h1>
        <p>Browse events by category</p>
      </div>

      {loading ? (
        <div className="spinner-wrap"><div className="spinner" /></div>
      ) : categories.length ? (
        <div className="grid-4">
          {categories.map((cat) => (
            <Link key={cat.id} to={`/events?category=${cat.id}`} className="card" style={{ display:'block', position:'relative', overflow:'hidden', minHeight:180 }}>
              <img src={`${imgBase}${cat.image}`} alt={cat.name} style={{ width:'100%', height:180, objectFit:'cover', opacity:0.5, transition:'opacity 0.3s' }} />
              <div style={{ position:'absolute', inset:0, display:'flex', flexDirection:'column', alignItems:'center', justifyContent:'flex-end', padding:'1rem', background:'linear-gradient(to top, rgba(15,15,26,0.9) 0%, transparent 60%)' }}>
                <h3 style={{ fontSize:'1rem', fontWeight:700, textAlign:'center' }}>{cat.name}</h3>
                <p style={{ fontSize:'0.75rem', color:'var(--text-muted)', marginTop:'0.25rem' }}>Explore events →</p>
              </div>
            </Link>
          ))}
        </div>
      ) : (
        <div className="empty-state">
          <div className="empty-state-icon">🗂</div>
          <h3>No categories found</h3>
        </div>
      )}
    </div>
  )
}
