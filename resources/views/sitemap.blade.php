<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="{{ url('/') }}">
    @foreach ($categories as $category)
    <url>
        <loc>{{ url('/products/'.$category?->slug) }}</loc>
        <loc>{{ $category?->name }}</loc>
        <lastmod>{{ $category?->created_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach

        @foreach ($products as $product)
            <url>
                <loc>{{ url('/products/'.$product?->slug) }}</loc>
                <loc>{{ $product?->name }}</loc>
                <lastmod>{{ $product?->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.9</priority>
            </url>
        @endforeach

        @foreach ($blogs as $blog)
            <url>
                <loc>{{ url('/blog-details/'.$blog?->slug) }}</loc>
                <loc>{{ $blog?->title }}</loc>
                <lastmod>{{ $blog?->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.9</priority>
            </url>
        @endforeach
</urlset>
