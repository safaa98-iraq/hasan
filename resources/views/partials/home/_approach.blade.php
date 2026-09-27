<section class="approach section page-shell" id="approach" aria-labelledby="approach-title">
    <div class="approach-heading">
        <p class="eyebrow dark">{{ $pages->get('approach_eyebrow')?->title }}</p>
        <h2 id="approach-title">{{ $pages->get('approach_heading')?->title }}</h2>
    </div>
    <div class="principles">
        @foreach ($approachPoints as $point)
            <article>
                <span>{{ $point->number }}</span>
                <h3>{{ $point->title }}</h3>
                <p>{{ $point->description }}</p>
            </article>
        @endforeach
    </div>
</section>
