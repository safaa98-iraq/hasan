<button type="button" class="theme-toggle" data-theme-toggle
    data-light-label="{{ app()->getLocale() === 'ar' ? 'الوضع الفاتح' : 'Light mode' }}"
    data-dark-label="{{ app()->getLocale() === 'ar' ? 'الوضع الداكن' : 'Dark mode' }}"
    aria-label="{{ app()->getLocale() === 'ar' ? 'الوضع الداكن' : 'Dark mode' }}" aria-pressed="false">
    <svg class="theme-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1.5 1.5m11 11L19 19M5 19l1.5-1.5m11-11L19 5"/></svg>
    <svg class="theme-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M20.4 13.2A8.5 8.5 0 0 1 10.8 3.6 8.5 8.5 0 1 0 20.4 13.2Z"/></svg>
    <span data-theme-label>{{ app()->getLocale() === 'ar' ? 'الوضع الداكن' : 'Dark mode' }}</span>
</button>
