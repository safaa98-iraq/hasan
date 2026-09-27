<section class="experiences section" aria-labelledby="experiences-title">
    <div class="page-shell">
        <p class="eyebrow">{{ $pages->get('categories_eyebrow')?->title }}</p>
        <h2 id="experiences-title">{{ $pages->get('categories_heading')?->title }}</h2>
        <div class="experience-grid">
            @foreach ($categories as $category)
                <article>
                    <span aria-hidden="true">{{ $category->numeral }}</span>
                    <h3>{{ $category->title }}</h3>
                    <p>{{ $category->description }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
