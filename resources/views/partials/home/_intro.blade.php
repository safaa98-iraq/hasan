<section class="introduction section page-shell" aria-labelledby="intro-title">
    <div class="section-label"><span>{{ $pages->get('intro_eyebrow')?->title }}</span></div>
    <div class="intro-copy">
        <h2 class="display-quote" id="intro-title">{{ $pages->get('intro_heading')?->title }}</h2>
        <div class="intro-detail">{!! $pages->get('intro_body')?->localizedParagraphs('body') !!}</div>
    </div>
</section>
