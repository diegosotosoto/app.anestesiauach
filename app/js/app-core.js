(function (window) {
  'use strict';

  function normalizeDecimalString(value) {
    if (value === null || value === undefined) return '';

    return String(value)
      .trim()
      .replace(/\s+/g, '')
      .replace(',', '.');
  }

  function parseDecimal(value) {
    const normalized = normalizeDecimalString(value);
    if (normalized === '') return null;

    const number = Number(normalized);
    return Number.isFinite(number) ? number : null;
  }

  function formatNumber(value, digits) {
    if (!Number.isFinite(value)) return '';

    const fractionDigits = Number.isInteger(digits) ? digits : 1;
    return value.toLocaleString('es-CL', {
      minimumFractionDigits: 0,
      maximumFractionDigits: fractionDigits
    });
  }

  function formatPercent(value, digits) {
    if (!Number.isFinite(value)) return '';

    const fractionDigits = Number.isInteger(digits) ? digits : 0;
    return value.toLocaleString('es-CL', {
      style: 'percent',
      minimumFractionDigits: 0,
      maximumFractionDigits: fractionDigits
    });
  }

  function safeSetText(target, value) {
    const element = typeof target === 'string' ? document.querySelector(target) : target;
    if (!element) return;

    element.textContent = value === null || value === undefined ? '' : String(value);
  }

  function appConfirm(message) {
    return window.confirm(message || 'Confirma esta accion.');
  }

  window.AppUI = window.AppUI || {};
  window.AppUI.normalizeDecimalString = window.AppUI.normalizeDecimalString || normalizeDecimalString;
  window.AppUI.parseDecimal = window.AppUI.parseDecimal || parseDecimal;
  window.AppUI.formatNumber = window.AppUI.formatNumber || formatNumber;
  window.AppUI.formatPercent = window.AppUI.formatPercent || formatPercent;
  window.AppUI.safeSetText = window.AppUI.safeSetText || safeSetText;
  window.AppUI.confirm = window.AppUI.confirm || appConfirm;

  window.normalizeDecimalString = window.normalizeDecimalString || normalizeDecimalString;
  window.parseDecimal = window.parseDecimal || parseDecimal;
  window.formatNumber = window.formatNumber || formatNumber;
  window.formatPercent = window.formatPercent || formatPercent;
  window.safeSetText = window.safeSetText || safeSetText;
})(window);
