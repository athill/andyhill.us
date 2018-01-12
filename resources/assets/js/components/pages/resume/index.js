import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { Helmet } from 'react-helmet';

import './resume.scss';

//// helpers
const Link = ({ href }) => (
	<a href={href} target="_blank" rel="noopener">{href}</a>
);

//// components
const Header = () => (
	<Row className="resume-header-wrapper">
		<Col className="resume-header" xs={12}>
			<div className="resume-name">Andrew T. Hill</div>
			<div className="resume-info">
				409 N. Roosevelt Bloomington, IN 47408 &bull; (812) 323-1590 &bull; <a href="mailto:athill@iu.edu">athill@iu.edu</a>
			</div>
			<div className="resume-info">
				<Link href="https://andyhill.us" /> &bull; <Link href="https://github.com/athill/" />
			</div>			
		</Col>
	</Row>
);

const Section = ({ title, Component }) => (
	<Row>
		<Col md={2} className="left-col">
			{ title }
		</Col>
		<Col md={10} className="right-col">
			<Component />
		</Col>		
	</Row>
);

const TitleDate = ({ date, title, leftWidth=9}) => (
	<Row className="title-date indent1">
		<Col xs={leftWidth} className="title">{title}</Col>
		<Col xs={12 - leftWidth} className="date">{date}</Col>
	</Row>

);

//// sections
const EducationCategory = ({title, entries }) => (
	<div>
		<div className="education-category-title">{ title }</div>
		{
			entries.map(({ date, title }, i) => <TitleDate key={`${title}-${i}`} title={title} date={date} />)	
		}
	</div>
);

const Objective = () => (
	<span>To apply and expand my computer skills in a challenging position. Specifically interested in writing code, the web, open source software, and network technologies.</span>
);

const schools = [
	{
		title: <span><strong>Udemy</strong>, <Link href="https://www.udemy.com//" /></span>,
		entries:  [
			{
				title: <span><a href="https://andyhill.us/media/resume/get-into-devops-cert.pdf" target="_blank" rel="noopener">Get Into DevOps</a></span>,
				date: '2017'
			},
		]
	},
	{
		title: <span><strong>Splunk</strong>, <Link href="https://www.splunk.com/" /></span>,
		entries:  [
			{
				title: <span>Splunk Power User Certification</span>,
				date: '2017'
			},
		]
	},
	{
		title: <span><strong>Coursera</strong>, <Link href="https://www.coursera.org/" /></span>,
		entries:  [
			{
				title: <span>Linear Algebra through C.S. Applications <a href="https://andyhill.us/media/resume/matrix_cert.pdf" target="_blank" rel="noopener">With Distinction</a></span>,
				date: '2013'
			},
			{
				title: <span>Software Engineering for Software as a Service (Part I) <a href="https://andyhill.us/media/resume/saas_cert.pdf" target="_blank" rel="noopener">1917.3/2126</a></span>,
				date: '2012'
			},
		]
	},
	{
		title: <span><strong>Indiana University</strong>, Bloomington, IN</span>,
		entries:  [
			{
				title: 'Graduate course: Computer Networks 4.0/4.0',
				date: '2007'
			},
			{
				title: 'Unix Systems Support Group Unix Certification',
				date: '2003'
			},
			{
				title: 'Bachelor of Science in Computer Science GPA since returning: 3.5/4.0',
				date: '2003'
			},
			{
				title: 'Completed coursework in Anthropology GPA 3.2/4.0',
				date: '1989-1992'
			},
		]
	},	
];
const Education = () => (
	<div>
	{
		schools.map(({ entries, title }, i) => <EducationCategory key={`${title}-${i}`} entries={entries} title={title} />)
	}
	</div>

);

const skillsets = [
	{
		title:  'Languages', 
		items:  ['Java', 'JavaScript', 'PHP', 'ColdFusion', 'Bash', 'Python']
	},
	{
		title:  'Web',
		items:  ['Spring Boot', 'Laravel', 'React', 'Redux', 'Webpack', 'HTML5', 'CSS3/Sass', 'D3.js']
	},
	{
		title:  'Data',
		items:  ['Elasticsearch', 'Redis', 'MySQL', 'Postgres', 'Oracle', 'SQL Server', 'MongoDB', 'LDAP/ADS']
	},
	{
		title: 'DevOps',
		items: ['CD/CI', 'Docker', 'Ansible', 'Bamboo', 'Jenkins', 'Splunk', 'Vagrant', 'DigitalOcean']
	}
];

const ComputerSkills = () => (
	<ul className="skillsets indent0">
	{
		skillsets.map(({title, items}, i) => <li key={`${title}-${i}`}><strong>{ title }</strong> { items.join(', ') }</li>)
	}
	</ul>
);

const Workplace = ({ jobs, title }) => (
	<div>
		<div>{ title }</div>
		{
			jobs.map(({ content, dates, department, title }, i) => {
				let indent = 1;
				const displayTitle = department ? `${department} - ${title}` : title;
				return (
					<div key={`${title}-${i}`}>
						
						<div className={`title-date indent${indent}`}>
							<TitleDate title={displayTitle} date={dates} />
						</div>
						<div className="indent3 clear">{ content }</div>
					</div>
				)
			})
		}
	</div>
);

const workplaces = [
	{
		title: <span><strong>Indiana University</strong>, Bloomington, IN</span>,
		jobs: [	
			{
				department:  'Enterprise Systems Middleware',
				title:  'Senior Programmer/Systems Analyst',
				dates:  '2014-Present',
				content:  'As a member of a small team, build and maintain internal IU websites using Spring Boot, React, and Redux. Provide middleware services and an integrated deployment process for other teams. Maintain enterprise Docker Data Center. Practice Continuous Delivery.'
			},		
			{
				department:  'University Student Services and Systems',
				title:  'Senior Programmer/Systems Analyst',
				dates:  '2005-2014',
				content:  'Maintained three extensive web sites in ColdFusion and PHP. Built frameworks in both ColdFusion and PHP based on convention over configuration principles. \
						Initiated using version control (Git).'
			},
			{
				department:  'Center for Survey Research',
				title:  'Web Programmer',
				dates:  '2004-2005',
				content:  'Implemented surveys on the web using ColdFusion/SQL Server. Modularized survey programming to improve consistency of display and function.'
			},
			{
				department:  'University Information Technology Services',
				title:  'Computer Lab Monitor, Help Desk',
				dates:  '2000-2004',
				content:  'Started as a computer lab consultant, was promoted to Support Staff position in May of 2002.'
			},
		]
	},
	{
		title: <span><strong>Various Restaurants</strong>, Bloomington and Indianapolis, IN</span>,
		jobs: [
			{
				title:  'Prep Cook, Line Cook, Dishwasher, Server, Busser',
				dates:  '1986-2002',
				content: 'Acquired work ethic, learned teamwork and interpersonal skills'
			}
		]
	}	
];

const WorkExperience = () => (
	<div className="work-experience">
	{
		workplaces.map(({ jobs, title }, i) => <Workplace key={`${title}-${i}`} title={title} jobs={jobs} />)
	}
	</div>
);

const Project = ({ description, link, name }) => (
	<div className="project">
	<Row>
		<Col sm={8} className="name"><em>{name}</em></Col>
		<Col sm={4} className="link"><Link href={link} /></Col>
	</Row>
	<Row className="indent1">
		{description}
	</Row>
	</div>
);

const projects = [
	{
		name: 'Informed Electorate',
		description: 'Civic information app using Laravel and React',
		link: 'https://informedelectorate.net'
	},	
	{
		name: "What's in my Freezer?",
		description: 'Inventory app using Laravel, React, and Redux',
		link: 'https://wimf.space'
	},
];
const Projects = () => (
	<div className="projects">
	{
		projects.map((project, i) => <Project key={i} {...project} />)
	}
	</div>
);

const References = () => (
	<span>Available upon request.</span>
);


//// render
const sections = [
	{ title: 'Objective', Component: Objective },
	{ title: 'Education', Component: Education },
	{ title: 'Skills', Component: ComputerSkills },
	{ title: 'Work', Component: WorkExperience },
	{ title: 'Projects', Component: Projects },
	{ title: 'References', Component: References }
];

const Resume = () => (
	<div className="container" id="resume">
		<Header />	
		{
			sections.map(({ title, Component }, i) => <Section key={`${title}-${i}`} title={title} Component={Component} />)
		}	
	</div>
);

const ResumePage = () => (
	<div>
		<Helmet>
			<title>andyhill.us - Resume</title>
		</Helmet>	
		<p className="screen-only">If you print this page, it will only print the resume. Alternatively, you can <a href="/media/resume/resume.pdf" target="_blank" rel="noopener">download a PDF</a></p>
		<Resume />
	</div>
);

export default ResumePage;