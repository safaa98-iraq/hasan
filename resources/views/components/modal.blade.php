@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
    $width = ['sm' => '24rem', 'md' => '28rem', 'lg' => '32rem', 'xl' => '36rem', '2xl' => '42rem'][$maxWidth] ?? '42rem';
@endphp

<div
    x-data="{
        show: @js($show),
        previousFocus: null,
        init() {
            this.$watch('show', value => this.toggleModal(value));
            if (this.show) this.$nextTick(() => this.toggleModal(true));
        },
        focusables() {
            return [...this.$el.querySelectorAll('a[href], button, input:not([type=hidden]), textarea, select, [tabindex]')]
                .filter(el => !el.disabled &amp;&amp; el.tabIndex >= 0 &amp;&amp; el.getClientRects().length);
        },
        toggleModal(value) {
            if (value) {
                this.previousFocus = document.activeElement;
                document.body.style.overflow = 'hidden';
                this.$nextTick(() => (this.focusables()[0] || this.$el).focus());
            } else {
                document.body.style.overflow = '';
                this.previousFocus?.focus();
            }
        },
        trapFocus(event) {
            const items = this.focusables();
            const first = items[0];
            const last = items[items.length - 1];
            if (!first) { event.preventDefault(); return; }
            if (event.shiftKey &amp;&amp; document.activeElement === first) {
                event.preventDefault(); last.focus();
            } else if (!event.shiftKey &amp;&amp; document.activeElement === last) {
                event.preventDefault(); first.focus();
            }
        }
    }"
    x-on:open-modal.window="if ($event.detail === @js($name)) show = true"
    x-on:close-modal.window="if ($event.detail === @js($name)) show = false"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="if (show) { $event.preventDefault(); show = false }"
    x-on:keydown.tab="trapFocus($event)"
    x-show="show"
    role="dialog"
    aria-modal="true"
    tabindex="-1"
    {{ $attributes->except('focusable')->class(['account-modal']) }}
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div class="account-modal-backdrop" x-on:click="show = false" aria-hidden="true"></div>
    <div class="account-modal-panel" style="max-width: {{ $width }};">
        {{ $slot }}
    </div>
</div>
