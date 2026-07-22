import { useState, useEffect, useCallback } from 'react'
import { Link, useSearchParams } from 'react-router-dom'
import api from '../api/api'

export default function Events() {
  const [searchParams, setSearchParams] = useSearchParams()
  const [events, setEvents] = useState([])
  const [loading, setLoading] = useState(true)
  const [categories, setCategories] = useState([])
  const [search, setSearch] = useState(searchParams.get('q') || '')
  const [selectedCat, setSelectedCat] = useState(searchParams.get('category') || '')
  const [page, setPage] = useState(1)
  const PER_PAGE = 9
  const imgBase = 'http://localhost:8000/images/upload/'

  const fetchEvents = useCallback(() => {
    setLoading(true)
    const payload = {}
    if (search) payload.search = search
    if (selectedCat) payload.category_id = selectedCat
    api.post('/user/events', payload)
      .then((r) => setEvents(r.data?.data || []))
      .finally(() => setLoading(false))
  }, [search, selectedCat])

  useEffect(() => { fetchEvents() }, [fetchEvents])
  useEffect(() => { api.get('/user/category').then((r) => setCategories(r.data?.data || [])) }, [])

  const handleSearch = (e) => {
    e.preventDefault()
    setPage(1)
    setSearchParams({ ...(search && { q: search }), ...(selectedCat && { category: selectedCat }) })
    fetchEvents()
  }

  const paginated = events.slice((page - 1) * PER_PAGE, page * PER_PAGE)
  const totalPages = Math.ceil(events.length / PER_PAGE)

  return (
    <div className="page-container">
      <div className="page-header">
        <h1>Browse Events</h1>
        <p>Find and book tickets for events near you</p>
      </div>

      {/* Filters */}
      <form onSubmit={handleSearch} style={{ display:'flex', gap:'0.75rem', flexWrap:'wrap', marginBottom:'2rem' }}>
        <input
          type="text"
          className="form-control"
          placeholder="Search events..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          style={{ flex:'1', minWidth:200 }}
        />
        <select
          className="form-control"
          value={selectedCat}
          onChange={(e) => { setSelectedCat(e.target.value); setPage(1) }}
          style={{ flex:'0 0 200px' }}
        >
          <option value="">All Categories</option>
          {categories.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
        </select>
        <button type="submit" className="btn btn-primary" style={{ flexShrink:0 }}>Search</button>
        {(search || selectedCat) && (
          <button type="button" className="btn btn-ghost" style={{ flexShrink:0 }}
            onClick={() => { setSearch(''); setSelectedCat(''); setPage(1); setSearchParams({}) }}>
            Clear
          </button>
        )}
      </form>

      {/* Results count */}
      {!loading && (
        <p style={{ color:'var(--text-muted)', fontSize:'0.875rem', marginBottom:'1.25rem' }}>
          Showing {paginated.length} of {events.length} events
        </p>
      )}

      {loading ? (
        <div className="spinner-wrap"><div className="spinner" /></div>
      ) : paginated.length ? (
        <div className="grid-3">
          {paginated.map((item) => {
            const slug = item.name?.replace(/\s+/g, '-').toLowerCase()
            return (
              <div key={item.id} className="card">
                <div style={{ position:'relative' }}>
                  <img src={`${imgBase}${item.image}`} alt={item.name} className="card-img" />
                  <span className="badge" style={{ position:'absolute', top:12, left:12 }}>{item.category?.name}</span>
                  {item.available_ticket === 0 && (
                    <span className="badge accent" style={{ position:'absolute', top:12, right:12 }}>Sold Out</span>
                  )}
                </div>
                <div className="card-body">
                  <div className="card-title">
                    <Link to={`/event/${item.id}/${slug}`}>{item.name}</Link>
                  </div>
                  <div className="card-meta">
                    <span className="badge accent">
                      📅 {new Date(item.start_time).toLocaleDateString('en-US', { weekday:'short', day:'numeric', month:'short', year:'numeric' })}
                    </span>
                  </div>
                  <div style={{ display:'flex', gap:'1rem', fontSize:'0.8rem', color:'var(--text-muted)', marginBottom:'1rem' }}>
                    <span>👥 {item.people}</span>
                    <span>🎟 {item.sold_ticket} sold</span>
                    <span style={{ color: item.available_ticket > 0 ? 'var(--success)' : 'var(--danger)' }}>
                      {item.available_ticket > 0 ? `✅ ${item.available_ticket} left` : '❌ Sold out'}
                    </span>
                  </div>
                  <Link to={`/event/${item.id}/${slug}`} className="btn btn-primary" style={{ width:'100%' }}>View Details</Link>
                </div>
              </div>
            )
          })}
        </div>
      ) : (
        <div className="empty-state">
          <div className="empty-state-icon">🔍</div>
          <h3>No events found</h3>
          <p>Try a different search or category filter.</p>
        </div>
      )}

      {/* Pagination */}
      {totalPages > 1 && (
        <div className="pagination">
          <button className="page-btn" disabled={page === 1} onClick={() => setPage(p => p - 1)}>‹</button>
          {Array.from({ length: totalPages }, (_, i) => i + 1).map((p) => (
            <button key={p} className={`page-btn ${p === page ? 'active' : ''}`} onClick={() => setPage(p)}>{p}</button>
          ))}
          <button className="page-btn" disabled={page === totalPages} onClick={() => setPage(p => p + 1)}>›</button>
        </div>
      )}
    </div>
  )
}
