import { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import api from '../api/api'

function EventCard({ item }) {
  const imgBase = 'http://localhost:8000/images/upload/'
  const slug = item.name?.replace(/\s+/g, '-').toLowerCase()
  return (
    <div className="card">
      <div style={{ position: 'relative' }}>
        <img src={`${imgBase}${item.image}`} alt={item.name} className="card-img" />
        <span className="badge" style={{ position:'absolute', top:12, left:12 }}>{item.category?.name}</span>
      </div>
      <div className="card-body">
        <div className="card-title">
          <Link to={`/event/${item.id}/${slug}`}>{item.name}</Link>
        </div>
        <div className="card-meta">
          <span className="badge accent">📅 {new Date(item.start_time).toLocaleDateString('en-US',{weekday:'short',day:'numeric',month:'short',year:'numeric'})}</span>
        </div>
        <div style={{ display:'flex', gap:'1rem', fontSize:'0.8rem', color:'var(--text-muted)', marginBottom:'1rem' }}>
          <span>👥 {item.people} people</span>
          <span>🎟 {item.sold_ticket} sold</span>
          <span style={{ color:'var(--success)' }}>✅ {item.available_ticket} left</span>
        </div>
        <Link to={`/event/${item.id}/${slug}`} className="btn btn-primary" style={{ width:'100%', justifyContent:'center' }}>
          View Details
        </Link>
      </div>
    </div>
  )
}

function CategoryCard({ item }) {
  const imgBase = 'http://localhost:8000/images/upload/'
  return (
    <Link to={`/events?category=${item.id}`} className="card" style={{ display:'block', position:'relative', overflow:'hidden', minHeight:140 }}>
      <img src={`${imgBase}${item.image}`} alt={item.name} style={{ width:'100%', height:140, objectFit:'cover', opacity:0.5 }} />
      <div style={{ position:'absolute', inset:0, display:'flex', alignItems:'center', justifyContent:'center', background:'linear-gradient(to top, rgba(15,15,26,0.85), transparent)' }}>
        <h3 style={{ fontSize:'1rem', fontWeight:700 }}>{item.name}</h3>
      </div>
    </Link>
  )
}

function BlogCard({ item }) {
  const imgBase = 'http://localhost:8000/images/upload/'
  const slug = item.title?.replace(/\s+/g, '-').toLowerCase()
  const title = item.title?.length > 60 ? item.title.slice(0, 60) + '…' : item.title
  return (
    <div className="card">
      <img src={`${imgBase}${item.image}`} alt={item.title} className="card-img" />
      <div className="card-body">
        <div className="card-meta">
          <span className="badge">{item.category?.name}</span>
          <span style={{ fontSize:'0.75rem', color:'var(--text-muted)' }}>
            {new Date(item.created_at).toLocaleDateString('en-US',{day:'numeric',month:'short',year:'numeric'})}
          </span>
        </div>
        <div className="card-title">
          <Link to={`/blog/${item.id}/${slug}`}>{title}</Link>
        </div>
        <Link to={`/blog/${item.id}/${slug}`} className="btn btn-ghost btn-sm" style={{ padding:'0.4rem 1rem', fontSize:'0.8rem' }}>Read More →</Link>
      </div>
    </div>
  )
}

export default function Home() {
  const [data, setData] = useState(null)
  const [loading, setLoading] = useState(true)
  const [bannerIdx, setBannerIdx] = useState(0)

  useEffect(() => {
    api.get('/frontend/home').then((r) => setData(r.data?.data || null)).finally(() => setLoading(false))
  }, [])

  // Auto-cycle banners
  useEffect(() => {
    if (!data?.banners?.length) return
    const t = setInterval(() => setBannerIdx((i) => (i + 1) % data.banners.length), 4000)
    return () => clearInterval(t)
  }, [data])

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>

  const { events=[], categories=[], blogs=[], banners=[], setting } = data || {}
  const banner = banners[bannerIdx]

  return (
    <>
      {/* Hero / Banner */}
      <div className="hero-banner">
        {banner && (
          <img src={`http://localhost:8000/images/upload/${banner.image}`} alt="" className="hero-slide-img" />
        )}
        <div className="hero-content">
          {banner ? (
            <>
              <h1>
                <span>{banner.title?.split(' ')[0]} </span>
                {banner.title?.split(' ').slice(1).join(' ')}
              </h1>
              <p>Discover incredible events happening near you. Book your tickets instantly.</p>
            </>
          ) : (
            <>
              <h1>Discover <span>Amazing</span> Events</h1>
              <p>Explore upcoming events, book tickets, and create unforgettable memories.</p>
            </>
          )}
          <div style={{ display:'flex', gap:'1rem', flexWrap:'wrap' }}>
            <Link to="/events" className="btn btn-primary">Browse Events 🎟</Link>
            <Link to="/categories" className="btn btn-outline">Explore Categories</Link>
          </div>
          {/* Banner dots */}
          {banners.length > 1 && (
            <div style={{ display:'flex', gap:'8px', marginTop:'1.5rem' }}>
              {banners.map((_, i) => (
                <button
                  key={i}
                  onClick={() => setBannerIdx(i)}
                  style={{ width: i === bannerIdx ? 24 : 8, height:8, borderRadius:4, background: i === bannerIdx ? 'var(--primary)' : 'rgba(255,255,255,0.3)', transition:'all 0.3s' }}
                  aria-label={`Banner ${i+1}`}
                />
              ))}
            </div>
          )}
        </div>
      </div>

      <div className="page-container">
        {/* Latest Events */}
        <section style={{ marginBottom:'4rem' }}>
          <div style={{ display:'flex', justifyContent:'space-between', alignItems:'center', marginBottom:'1.5rem' }}>
            <h2 className="section-title" style={{ margin:0 }}>Latest <span>Events</span></h2>
            <Link to="/events" className="btn btn-ghost" style={{ padding:'0.4rem 1rem', fontSize:'0.85rem' }}>View All →</Link>
          </div>
          {events.length ? (
            <div className="grid-3">
              {events.slice(0, 6).map((e) => <EventCard key={e.id} item={e} />)}
            </div>
          ) : (
            <div className="empty-state">
              <div className="empty-state-icon">📅</div>
              <h3>No events right now</h3>
              <p>Check back soon for upcoming events!</p>
            </div>
          )}
        </section>

        {/* Featured Categories */}
        <section style={{ marginBottom:'4rem' }}>
          <div style={{ display:'flex', justifyContent:'space-between', alignItems:'center', marginBottom:'1.5rem' }}>
            <h2 className="section-title" style={{ margin:0 }}>Featured <span>Categories</span></h2>
            <Link to="/categories" className="btn btn-ghost" style={{ padding:'0.4rem 1rem', fontSize:'0.85rem' }}>All Categories →</Link>
          </div>
          <div className="grid-4">
            {categories.slice(0, 8).map((c) => <CategoryCard key={c.id} item={c} />)}
          </div>
        </section>

        {/* Latest Blogs */}
        {blogs.length > 0 && (
          <section style={{ marginBottom:'2rem' }}>
            <div style={{ display:'flex', justifyContent:'space-between', alignItems:'center', marginBottom:'1.5rem' }}>
              <h2 className="section-title" style={{ margin:0 }}>Our Latest <span>Blogs</span></h2>
              <Link to="/blogs" className="btn btn-ghost" style={{ padding:'0.4rem 1rem', fontSize:'0.85rem' }}>All Blogs →</Link>
            </div>
            <div className="grid-3">
              {blogs.slice(0, 3).map((b) => <BlogCard key={b.id} item={b} />)}
            </div>
          </section>
        )}
      </div>
    </>
  )
}
