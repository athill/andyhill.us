import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { Helmet } from 'react-helmet';

import './portfolio.scss';

const PortfolioItem = ({alt, children, image, link, source, title }) => (
	<Row className='portfolio-entry'>
		<Col md={3} className="portfolio-link">
			<a href={link} target="_blank" rel="noopener">
				<h3>{ title }</h3>
				<img src={image} alt={alt} />
			</a>
		</Col>
		<Col md={9}>
			{children}
			{ source && <p><strong>Source code: </strong><a href={source} target="_blank" rel="noopener">{source}</a></p> }
		</Col>
	</Row>
);


const PortfolioPage = () => (
	<div id="portfolio">
		<Helmet>
			<title>andyhill.us - Portfolio</title>
		</Helmet>	
		<h2>Portfolio</h2>

		{/* Informed Electorate */}
		<PortfolioItem alt="Informed Electorate website" 
				image="/images/portfolio/informedelectorate.png" 
				link="https://informedelectorate.net" 
				title="Informed Electorate"
				source="https://github.com/athill/informedelectorate.net">
			<p>Trying to encourage civic engagement. Look up your representatives, view current federal and state bills, 
			upcoming election information, and more!</p>
			<p>Laravel/React stack. Uses APIs from Pro Publica, Google, and others to provide the data.</p>

		</PortfolioItem>

		{/* WIMF */}
		<PortfolioItem alt="What's in my Freezer? website" 
				image="/images/portfolio/wimf-screenshot.png" 
				link="https://wimf.space" 
				title="What's in my Freezer?"
				source="https://github.com/athill/wimf">
			<p>An inventory management tool. Maintain inventory in multiple containers. Filter items to quickly see what&apos;on hand.</p>
			<p>Laravel/React/Redux stack.</p>
		</PortfolioItem>		

		{/* Pizza King */}
		<PortfolioItem alt="Pizza King of Carmel website" 
				image="/images/portfolio/pizzakingscreencap.png" 
				link="http://pizzakingofcarmel.com" 
				title="Pizza King of Carmel"
				source="https://github.com/athill/pizzakingofcarmel.com">
			<p>I created and maintain the Pizza King of Carmel site for my cousin, Jeff. It's a good place and he's a good guy, you should check it out.</p>	
			<p>Still rocking jQuery and vanilla PHP on this one.</p>
		</PortfolioItem>

		{/* PWA */}
		<PortfolioItem alt="Progressive Web Apps screencap" 
				image="/images/portfolio/pwa-screencap-219px.png" 
				link="https://athill.github.io/pwa-presentation/" 
				title="Progressive Web Apps"
				source="https://github.com/athill/pwa-presentation">
			<p>Presentation I did for IU Developers Community of Practice. Advocates PWAs and helps getting started. </p>
			<p>Uses <a href="https://revealjs.com/" target="_blank" rel="noopener">Reveal.js</a> to generate the slideshow</p>
		</PortfolioItem>

		{/* Metaprogramming */}
		<PortfolioItem alt="Metaprogramming in ColdFusion screencap" 
				image="/images/portfolio/cfmeta.png" 
				link="/cfmeta" 
				title="Metaprogramming in ColdFusion"
				source="https://github.com/athill/cfmeta">
			<p>Presentation I did for <a href="https://www.meetup.com/coldfusionmeetup/" target="_blank" rel="noopener">The Online ColdFusion Meetup</a>.&nbsp; 
			Demonstrates functional and meta-programming techniques in ColdFusion such as currying and introspection.
			</p>
			<p>Uses <a href="https://revealjs.com/" target="_blank" rel="noopener">Reveal.js</a> to generate the slideshow</p>
		</PortfolioItem>

		{/* URL to Webpage */}
		<PortfolioItem alt="From URL to Webpage screencap" 
				image="/images/portfolio/url2web.png" 
				link="/media/portfolio/From URL to Web Page.zip" 
				title="From URL to Webpage">
			<p>Presentation I did to inform work colleagues about how web pages work. Including URL components, network routing, and page generation.</p>
		</PortfolioItem>

		{/* game-of-life-jquery-bootstrap */}
		<PortfolioItem alt="jquery-readmore screencap" 
				image="/images/portfolio/game-of-life-screencap.png" 
				link="https://athill.github.io/game-of-life-jquery-bootstrap/" 
				title="Conway's Game of Life"
				source="https://github.com/athill/game-of-life-jquery-bootstrap">
			<p>Implementation of <a href="https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life" target="_blank" rel="noopener">Conway's Game of Life</a> in jQuery. Fun for the whole family!</p>
		</PortfolioItem>		

		{/* jquery-readmore */}
		<PortfolioItem alt="jquery-readmore screencap" 
				image="/images/portfolio/jquery-readmore.png" 
				link="https://athill.github.io/jquery-readmore/" 
				title="jquery-readmore"
				source="https://github.com/athill/jquery-readmore">
			<p>jQuery plugin I wrote when I couldn't find the functionality elsewhere. Allows customizable expansion and contraction of text</p>
		</PortfolioItem>
	</div>
);

export default PortfolioPage;