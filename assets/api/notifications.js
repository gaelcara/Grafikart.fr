import { jsonFetch } from '/functions/api.js'

let isMercureConnected = false

function emitEvent (notification) {
  notification.createdAt = new Date(notification.createdAt)
  window.dispatchEvent(
    new CustomEvent('gnotification', {
      detail: notification
    })
  )
}

/**
 * Charge les notifications (en Ajax) et se connecte au SSE
 */
export async function loadNotifications () {
  // On récupère les dernières notifications en AJAX
  const notifications = await fetchAll(15)
  notifications.reverse()
  notifications.forEach(emitEvent)

  // On se connecte au SSE
  if (isMercureConnected === false) {
    const url = new URL(window.grafikart.MERCURE_URL)
    url.searchParams.append('topic', '/notifications/{channel}')
    url.searchParams.append('topic', `/notifications/user/${window.grafikart.USER}`)
    const eventSource = new EventSource(url, { withCredentials: true })
    eventSource.onmessage = e => emitEvent(JSON.parse(e.data))
    isMercureConnected = true
  }
  return notifications
}

export async function fetchAll (count) {
  return await jsonFetch(`/api/notifications?count=${count}`)
}
