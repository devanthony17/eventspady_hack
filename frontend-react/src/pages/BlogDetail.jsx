import { useState, useEffect } from 'react'
import { useParams, Link } from 'react-router-dom'
import api from '../api/api'

export default function BlogDetail() {
  const { id } = useParams()
  const [blog, setBlogs] = useState(null)
  const [loading, setLoading] = useState(true)
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    // Fetch all blogs and find the one by id (no dedicated single-blog endpoint)
    api.get('/frontend/home')
      .then((r) => {
        const blogs = r.data?.data?.blogs || []
        setBlogs(blogs.find((b) => String(b.id) === String(id)) || null)
      })
      .finally(() => setLoading(false))
  }, [id])

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>
  if (!blog) return (
    <div className="page-container">
      <div className="empty-state">
        <div className="empty-state-icon">😕</div>
        <h3>Blog post not found</h3>
        <Link to="/blogs" className="btn btn-primary" style={{ marginTop:'1rem' }}>Back to Blogs</Link>
      </div>
    </div>
  )

  return (
    <div className="page-container" style={{ maxWidth:860 }}>
      {/* Breadcrumb */}
      <div style={{ display:'flex', gap:'0.5rem', alignItems:'center', color:'var(--text-muted)', fontSize:'0.875rem', marginBottom:'1.5rem' }}>
        <Link to="/">Home</Link> <span>›</span>
        <Link to="/blogs">Blogs</Link> <span>›</span>
        <span style={{ color:'var(--text)' }}>{blog.title?.slice(0, 40)}…</span>
      </div>

      <div className="card-meta" style={{ marginBottom:'1rem' }}>
        <span className="badge">{blog.category?.name}</span>
        <span style={{ fontSize:'0.8rem', color:'var(--text-muted)' }}>
          📅 {new Date(blog.created_at).toLocaleDateString('en-US',{weekday:'long',day:'numeric',month:'long',year:'numeric'})}
        </span>
      </div>

      <h1 style={{ fontSize:'clamp(1.5rem, 3vw, 2.25rem)', fontWeight:800, lineHeight:1.3, marginBottom:'1.5rem' }}>{blog.title}</h1>

      <img src={`${imgBase}${blog.image}`} alt={blog.title} style={{ width:'100%', maxHeight:440, objectFit:'cover', borderRadius:'var(--radius)', marginBottom:'2rem' }} />

      {blog.description ? (
        <div style={{ color:'var(--text-muted)', lineHeight:1.9, fontSize:'1rem' }} dangerouslySetInnerHTML={{ __html: blog.description }} />
      ) : (
        <p style={{ color:'var(--text-muted)' }}>No content available for this blog post.</p>
      )}

      <div style={{ marginTop:'2.5rem', paddingTop:'1.5rem', borderTop:'1px solid var(--border)' }}>
        <Link to="/blogs" className="btn btn-ghost">← Back to Blogs</Link>
      </div>
    </div>
  )
}
