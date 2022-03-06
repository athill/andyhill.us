import React from 'react';
import { Helmet } from 'react-helmet';

const BlogsPage = () => (
	<div>
		<Helmet>
			<title>andyhill.us - Blogs</title>
		</Helmet>	
		<p>As of this writing, I haven't updated either of these blogs for a while. I still like the ideas, so I'll try to address that.</p>
		<p>
			<a href="https://athill.github.io" target="_blank" rel="noopener">codeblog</a> is a blog related especially to code, but branches into other 
technologies that relate to the web, such as audio, video, and image 
editors. 
		</p>
		<p>
			<a href="http://ttmsoia.andyhill.us" target="_blank" rel="noopener">trying to make sense of it all</a> is about everything else, sometimes concerning politics and religion (you've 
been warned), but potentially whatever's on my mind.
		</p>
	</div>
);

export default BlogsPage;