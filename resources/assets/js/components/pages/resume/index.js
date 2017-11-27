import React from 'react';
import { Col, Row } from 'react-bootstrap';

import './resume.scss';

const Link = ({ href }) => (
	<a href={href}>{href}</a>
);


//$h->div('Andrew T.Hill', ['class' => 'resume-name']);
const Header = () => (
	<Row className="resume-header-wrapper">
		<Col className="resume-header" xs={12}>
			<div className="resume-name">Andrew T. Hill</div>
			<div className="resume-info">
				409 N. Roosevelt Bloomington, IN 47408 &bull; (812)323-1590 &bull; <a href="mailto:athill@iu.edu">athill@iu.edu</a>
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
		title: <span><strong>Coursera</strong>, <a href="https://www.coursera.org/" target="_blank">https://www.coursera.org/</a></span>,
		entries:  [
			{
				title: <span>Linear Algebra through C.S. Applications <a href="http://andyhill.us/resume/matrix_cert.pdf" target="_blank">With Distinction</a></span>,
				date: 'September 2013'
			},
			{
				title: <span>Software Engineering for Software as a Service (Part I) <a href="http://andyhill.us/resume/saas_cert.pdf" target="_blank">1917.3/2126</a></span>,
				date: 'March 2012'
			},
		]
	},
	{
		title: <span><strong>Indiana University</strong>, Bloomington, IN</span>,
		entries:  [
			{
				title: 'Graduate course: Computer Networks 4.0/4.0',
				date: 'December 2007'
			},
			{
				title: 'Unix Systems Support Group Unix Certification',
				date: 'August 2003'
			},
			{
				title: 'Bachelor of Science in Computer Science GPA since returning: 3.5/4.0',
				date: 'May 2003'
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
	{title:  'Languages', 
		items:  ['Java', 'JavaScript', 'ColdFusion', 'PHP', 'Apache Ant', 'C/C++', 'Bash', 'Python', 'Ruby', 'C#', 'Scheme', 'Perl']
	},
	{title:  'Web',
		items:  ['Spring Boot', 'Laravel', 'React', 'Redux', 'Webpack', 'HTML5', 'jQuery', 'CSS3/Sass', 'D3.js']
	},
	{title:  'Data',
		items:  ['Elasticsearch', 'MongoDB', 'Oracle', 'MySQL', 'SQL Server', 'LDAP/ADS', 'JSON', 'XML', 'XPath']
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
				return (
					<div key={`${title}-${i}`}>
						{ department && <div className={`clear indent${indent++}`}><em>{ department }</em></div> }
						<div className={`title-date indent${indent}`}>
							<TitleDate title={title} date={dates} />
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
				department:  'Enterprise Systems Integration Middleware',
				title:  'Senior Programmer/Systems Analyst',
				dates:  '2014-Present',
				content:  'As a member of a small team, maintain Kuali Rice implementation including updatating document search to use an Elasticsearch back end and build and maintain other sites which use Spring Boot, React, and Redux. We strive for continuos integration (Bamboo), practice scrum, and believe in testing, linting, peer-review and other best practices. We also maintain various services for other enterprise services, including a Nexus repository for Java and NPM artifacts, an integrated deployment process, and Elasticsearch as a service.'
			},		
			{
				department:  'University Student Services and Systems',
				title:  'Senior Programmer/Systems Analyst',
				dates:  '2005-2014',
				content:  'Maintained three extensive web sites in ColdFusion and PHP with Oracle, SQL Server, and MySQL back ends using jQuery and AJAX technologies. Build frameworks in both ColdFusion and PHP based on convention over configuration principles, allowing overrides at directory or page level, including a system to easily include jQuery plugins where needed. The frameworks have toolsets to ease sending emails, interacting with database and LDAP data stores, generating HTML, rendering and processing forms, and other common tasks. Initiated using version control (Git).'
			},
			{
				department:  'Center for Survey Research',
				title:  'Web Programmer',
				dates:  '2004-2005',
				content:  'Implemented surveys on the web using ColdFusion/SQL Server, 	created interfaces for survey sponsors to view and interact \
				        with acquired data, and maintained external and internal web sites including internal survey tracking. Modularized survey programming to improve consistency of display and function, simplified and streamlined \
				        rendering and handling of survey questions. Implemented a primitive, but functional, time-keeping system.'
			},
			{
				department:  'University Information Technology Services',
				title:  'Computer Lab Monitor, Help Desk',
				dates:  '2000-2004',
				content:  'Started as a computer lab consultant, was promoted to Support Staff position in May of 2002, which entailed supervising 140 consultants, acting as go-between to \
				    UITS higher-ups, and helping with difficult customer issues. Also contributed functionality to internal website using Perl. \
				    As a Support Center Consultant (2003), Assisted walk-in and telephone customers with computer related problems including networking, hardware, authentication, and security issues. Continued in Support Staff Position.'
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

const References = () => (
	<span>Available upon request.</span>
);

const sections = [
	{ title: 'Objective', Component: Objective },
	{ title: 'Education', Component: Education },
	{ title: 'Computer Skills', Component: ComputerSkills },
	{ title: 'Work Experience', Component: WorkExperience },
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
		<p className="screen-only">If you print this page, it will only print the resume. Alternatively, you can <a href="resume.pdf" target="_blank">download a PDF</a></p>
		<Resume />
	</div>
);

export default ResumePage;