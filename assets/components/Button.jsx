import { Loader } from './Form.jsx'

export function PrimaryButton ({ children, ...props }) {
  return (
    <Button className='btn-primary' {...props}>
      {children}
    </Button>
  )
}

export function SecondaryButton ({ children, ...props }) {
  return (
    <Button className='btn-secondary' {...props}>
      {children}
    </Button>
  )
}

export function Button ({ children, className = '', loading = false, ...props }) {
  return (
    <button className={'btn ' + className} disabled={loading} {...props}>
      {loading && <Loader className='icon' />}
      {children}
    </button>
  )
}

export function RoundedButton ({ children, loading = false, type = '', title = '', ...props }) {
  return (
    <button
      className={'rounded-button ' + type}
      aria-label={title}
      data-microtip-position='top'
      role='tooltip'
      {...props}
    >
      <span>{loading ? children : <spinning-dots className='icon' />}</span>
    </button>
  )
}
