(function () {
  const endpoint = window.APP_PUSH_ENDPOINT || '/push_subscription.php';

  function isIos() {
    return /iphone|ipad|ipod/i.test(navigator.userAgent || '') || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
  }

  function isStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
  }

  function base64UrlToUint8Array(base64Url) {
    const padding = '='.repeat((4 - base64Url.length % 4) % 4);
    const base64 = (base64Url + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw = window.atob(base64);
    const output = new Uint8Array(raw.length);
    for (let i = 0; i < raw.length; i++) output[i] = raw.charCodeAt(i);
    return output;
  }

  async function sha256Hex(value) {
    const buffer = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(value));
    return Array.from(new Uint8Array(buffer)).map(b => b.toString(16).padStart(2, '0')).join('');
  }

  function supportsPush() {
    return 'serviceWorker' in navigator && 'PushManager' in window && 'Notification' in window && window.isSecureContext;
  }

  function platformLabel() {
    if (isIos()) return isStandalone() ? 'ios-standalone' : 'ios-browser';
    if (/android/i.test(navigator.userAgent || '')) return 'android';
    return 'web';
  }

  async function getConfig(subscription) {
    let url = endpoint;
    if (subscription && subscription.endpoint) {
      url += '?endpoint_hash=' + encodeURIComponent(await sha256Hex(subscription.endpoint));
    }
    const response = await fetch(url, { credentials: 'same-origin' });
    if (!response.ok) throw new Error('No se pudo obtener configuración push.');
    return response.json();
  }

  async function getRegistration() {
    await navigator.serviceWorker.ready;
    return navigator.serviceWorker.getRegistration('/');
  }

  async function subscribe() {
    if (!supportsPush()) throw new Error('Este navegador no soporta Web Push o no está en HTTPS.');
    if (isIos() && !isStandalone()) throw new Error('En iPhone/iPad primero agrega la app a la pantalla de inicio y ábrela desde el ícono.');

    const registration = await getRegistration();
    if (!registration) throw new Error('Service Worker no registrado.');

    const config = await getConfig();
    if (!config.enabled || !config.publicKey || config.publicKey.indexOf('REEMPLAZAR_') === 0) {
      throw new Error('Push no está configurado con clave pública VAPID.');
    }

    const permission = await Notification.requestPermission();
    if (permission !== 'granted') throw new Error('Permiso de notificaciones no concedido.');

    const subscription = await registration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: base64UrlToUint8Array(config.publicKey)
    });

    const response = await fetch(endpoint, {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        subscription: subscription.toJSON(),
        contentEncoding: (PushManager.supportedContentEncodings && PushManager.supportedContentEncodings[0]) || 'aes128gcm',
        platform: platformLabel()
      })
    });

    const data = await response.json();
    if (!response.ok || !data.ok) throw new Error(data.error || 'No se pudo guardar la suscripción.');
    return data;
  }

  async function unsubscribe() {
    if (!supportsPush()) return false;
    const registration = await getRegistration();
    if (!registration) return false;
    const subscription = await registration.pushManager.getSubscription();
    if (!subscription) return true;

    await fetch(endpoint + '?action=unsubscribe', {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ endpoint: subscription.endpoint })
    });

    return subscription.unsubscribe();
  }

  function createControl() {
    if (document.getElementById('push-enable-btn')) return;
    if (!supportsPush()) return;

    const host = document.getElementById('notif-list') || document.body;
    const wrap = document.createElement('div');
    wrap.className = host === document.body ? 'position-fixed bottom-0 end-0 m-3 z-3' : 'notif-dropdown-footer border-top';
    wrap.innerHTML = '<button type="button" id="push-enable-btn" class="btn btn-sm notif-btn-primary w-100"><i class="fa-solid fa-bell pe-1"></i> Activar notificaciones push</button><div id="push-enable-help" class="small text-muted mt-2"></div>';
    host.appendChild(wrap);

    const btn = document.getElementById('push-enable-btn');
    const help = document.getElementById('push-enable-help');

    if (isIos() && !isStandalone()) {
      btn.disabled = true;
      help.textContent = 'En iOS: Compartir → Agregar a pantalla de inicio. Luego abre la app desde el ícono.';
      return;
    }

    navigator.serviceWorker.ready.then(function (reg) {
      return reg.pushManager.getSubscription();
    }).then(async function (sub) {
      if (!sub) return;
      const config = await getConfig(sub);
      if (config.active) {
        // Remove the control entirely if notifications are already active
        wrap.remove();
      }
    }).catch(function () {});

    btn.addEventListener('click', async function () {
      btn.disabled = true;
      const original = btn.innerHTML;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin pe-1"></i> Activando...';
      help.textContent = '';
      try {
        await subscribe();
        btn.innerHTML = '<i class="fa-solid fa-check pe-1"></i> Notificaciones activadas';
        btn.classList.remove('notif-btn-primary');
        btn.classList.add('btn-success');
      } catch (err) {
        console.error(err);
        help.textContent = err.message || 'No se pudo activar push.';
        btn.innerHTML = original;
        btn.disabled = false;
      }
    });
  }

  window.AppPushNotifications = { subscribe, unsubscribe, supportsPush, isIos, isStandalone };
  document.addEventListener('DOMContentLoaded', createControl);
})();
