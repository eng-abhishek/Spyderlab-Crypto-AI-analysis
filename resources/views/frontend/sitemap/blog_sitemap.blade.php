<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@foreach ($posts as $post)
	<url>
		<loc>{{route('blog.details', ['slug' => $post->slug])}}</loc>
		<lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($post->updated_at)) }}</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
	</url>
	@endforeach
</urlset>