import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import api from '../api/api'

export default function Blog() {
  const [blogs, setBlogs] = useState([])
  const [loading, setLoading] = useState(true)
  const [page, setPage] = useState(1)
  const PER_PAGE = 9
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    // Blogs are returned from the home endpoint or a dedicated one
    api.get('/frontend/home').then((r) => setBlogs(r.data?.data?.blogs || [])).finally(() => setLoading(false))
  }, [])

  const paginated = blogs.slice((page - 1) * PER_PAGE, page * PER_PAGE)
  const totalPages = Math.ceil(blogs.length / PER_PAGE)

  return (
    <div className="page-container">
      <div className="page-header">
        <h1>Latest Blogs</h1>
        <p>Articles, tips and updates from our team</p>
      </div>

      {loading ? (
        <div className="spinner-wrap"><div className="spinner" /></div>
      ) : paginated.length ? (
        <>
          <div className="grid-3">
            {paginated.map((item) => {
              const slug = item.title?.replace(/\s+/g, '-').toLowerCase()
              const title = item.title?.length > 70 ? item.title.slice(0, 70) + '…' : item.title
              return (
                <div key={item.id} className="card">
                  <div style={{ overflow:'hidden', height:200 }}>
                    <img src={`${imgBase}${item.image}`} alt={item.title} style={{ width:'100%', height:'100%', objectFit:'cover', transition:'transform 0.4s' }}
                      onMouseOver={(e) => e.currentTarget.style.transform = 'scale(1.05)'}
                      onMouseOut={(e) => e.currentTarget.style.transform = 'scale(1)'}
                    />
                  </div>
                  <div className="card-body">
                    <div className="card-meta">
                      <span className="badge">{item.category?.name}</span>
                      <span style={{ fontSize:'0.75rem', color:'var(--text-muted)' }}>
                        {new Date(item.created_at).toLocaleDateString('en-US',{day:'numeric',month:'short',year:'numeric'})}
                      </span>
                    </div>
                    <div className="card-title" style={{ marginBottom:'1rem' }}>
                      <Link to={`/blog/${item.id}/${slug}`}>{title}</Link>
                    </div>
                    <Link to={`/blog/${item.id}/${slug}`} className="btn btn-outline" style={{ fontSize:'0.85rem', padding:'0.4rem 1.1rem' }}>
                      Read More →
                    </Link>
                  </div>
                </div>
              )
            })}
          </div>
          {totalPages > 1 && (
            <div className="pagination">
              <button className="page-btn" disabled={page === 1} onClick={() => setPage(p => p - 1)}>‹</button>
              {Array.from({ length: totalPages }, (_, i) => i + 1).map((p) => (
                <button key={p} className={`page-btn ${p === page ? 'active' : ''}`} onClick={() => setPage(p)}>{p}</button>
              ))}
              <button className="page-btn" disabled={page === totalPages} onClick={() => setPage(p => p + 1)}>›</button>
            </div>
          )}
        </>
      ) : (
        <div className="empty-state">
          <div className="empty-state-icon">📄</div>
          <h3>No blogs yet</h3>
          <p>Check back soon!</p>
        </div>
      )}
    </div>
  )
}
