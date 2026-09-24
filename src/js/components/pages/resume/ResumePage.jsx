//// helpers
const Link = ({ href }) => (
	<a href={href} target="_blank" rel="noreferrer">{href}</a>
);

const SubHeader = ({ items }) => (
	<ul className="flex space-x-4 list-disc justify-center gap-2 text-sm">
		{items.map((item, i) => <li key={i} className={i === 0 ? 'list-none' : null}>{item}</li>)}
	</ul>
);

//// components
const Header = () => (
	<div className="">
    <div className="text-3xl border-b-2 border-black">Andrew T. Hill</div>
    <SubHeader items={[
      '409 N. Roosevelt Bloomington, IN 47408',
      '(812) 323-1590',
      <a href="mailto:athill@iu.edu">athill@iu.edu</a>
    ]} />
    <SubHeader items={[
      <Link href="https://andyhill.us" />,
      <Link href="https://github.com/athill/" />
    ]} />
  </div>
);

const Section = ({ title, Component }) => (
	<div className="sm:grid sm:grid-cols-6">
		<div className="sm:col-span-1 font-bold">
			{ title }
		</div>
		<div className="sm:col-span-5">
			<Component />
		</div>
	</div>
);

const TitleDate = ({ date, title, leftWidth=9}) => (
	<div className="flex justify-between pl-1">
		<div className="italic">{title}</div>
		<div className="">{date}</div>
	</div>

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
				title: <span><a href="https://andyhill.us/media/resume/get-into-devops-cert.pdf" target="_blank" rel="noreferrer">Get Into DevOps</a></span>,
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
				title: <span>Linear Algebra through C.S. Applications <a href="https://andyhill.us/media/resume/matrix_cert.pdf" target="_blank" rel="noreferrer">With Distinction</a></span>,
				date: '2013'
			},
			{
				title: <span>Software Engineering for Software as a Service (Part I) <a href="https://andyhill.us/media/resume/saas_cert.pdf" target="_blank" rel="noreferrer">1917.3/2126</a></span>,
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
				content:  'As a member of a small team, build and maintain internal IU websites using Spring Boot, React, and Redux. Provide middleware services such as Redis and RabbitMQ for other teams. Maintain enterprise TKGI Kubernetes environment. Practice Continuous Delivery.'
			},
			{
				department:  'University Student Services and Systems',
				title:  'Senior Programmer/Systems Analyst',
				dates:  '2005-2014',
				content:  'Maintained three extensive web sites in ColdFusion and PHP. Built frameworks in both ColdFusion and PHP based on convention over configuration principles. ' +
						'Initiated using version control (Git).'
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

const References = () => (
	<span>Available upon request.</span>
);


//// render
const sections = [
	{ title: 'Objective', Component: Objective },
	{ title: 'Education', Component: Education },
	{ title: 'Skills', Component: ComputerSkills },
	{ title: 'Work', Component: WorkExperience },
	// { title: 'Projects', Component: Projects },
	{ title: 'References', Component: References }
];

const Resume = () => (
	<div className="bg-white text-black p-6">
		<Header />
		{
			sections.map(({ title, Component }, i) => <Section key={`${title}-${i}`} title={title} Component={Component} />)
		}
	</div>
);

const ResumePage = () => (
	<div>
		<title>andyhill.us - Resume</title>
		<p className="block print:hidden m-1">If you print this page, it will only print the resume. Alternatively, you can <a href="/media/resume/resume.pdf" target="_blank" rel="noreferrer">download a PDF</a></p>
		<Resume />
	</div>
);

export default ResumePage;
