import React from 'react';
import { Col, Row } from 'react-bootstrap';

import './portfolio.scss';

const PortfolioItem = ({alt, children, image, link, title }) => (
	<Row className='portfolio-entry'>
		<Col md={3} className="portfolio-link">
			<a href={link} target="_blank" rel="noopener">
				<h3>{ title }</h3>
				<img src={image} alt={alt} />
			</a>
		</Col>
		<Col md={9}>
			{children}
		</Col>
	</Row>
);


const PortfolioPage = () => (
	<div id="portfolio">
		<h2>Portfolio</h2>

		{/* Informed Electorate */}
		<PortfolioItem alt="Informed Electorate website" 
				image="/images/portfolio/informedelectorate.png" 
				link="https://informedelectorate.net" 
				title="Informed Electorate">
			Skeleton of site idea that would encourage civic engagement.
		</PortfolioItem>

		{/* WIMF */}
		<PortfolioItem alt="What's in my Freezer? website" 
				image="/images/portfolio/wimf-screenshot.png" 
				link="https://wimf.space" 
				title="What's in my Freezer?">
			An inventory management tool.
		</PortfolioItem>		

		{/* Pizza King */}
		<PortfolioItem alt="Pizza King of Carmel website" 
				image="/images/portfolio/pizzakingscreencap.png" 
				link="http://pizzakingofcarmel.com" 
				title="Pizza King of Carmel">
			I created and maintain the Pizza King site for my cousin, Jeff. It's a good place and he's a good guy, you should check it out.			
		</PortfolioItem>

		{/* Metaprogramming */}
		<PortfolioItem alt="Metaprogramming in ColdFusion screencap" 
				image="/images/portfolio/cfmeta.png" 
				link="/cfmeta" 
				title="Metaprogramming in ColdFusion">
			Presentation I did for cfmeetup. 		
		</PortfolioItem>

		{/* URL to Webpage */}
		<PortfolioItem alt="From URL to Webpage screencap" 
				image="/images/portfolio/url2web.png" 
				link="/media/portfolio/From URL to Web Page.zip" 
				title="From URL to Webpage">
			Presentation I did for cfmeetup. 		
		</PortfolioItem>
	</div>
);

export default PortfolioPage;