<?php

class Resume {


	public function render() {
		global $h;
		$h->odiv(['id' => 'resume', 'class' => 'container']);
		$this->header();
		$sections = [
			['title' => 'Objective', 'callbackName' => 'objective'],
			['title' => 'Education', 'callbackName' => 'education'],
			['title' => 'Computer Skills', 'callbackName' => 'computerSkills'],
			['title' => 'Work Experience', 'callbackName' => 'workExperience'],
			['title' => 'References', 'callbackName' => 'references'],
			// ['title' => '', 'callbackName' => ''],
		];

		foreach ($sections as $section) {
			$this->section($section['title'], $section['callbackName']);
		}

		$h->cdiv('/#resume');
	}

	public function header() {
	    global $h;
	    $h->odiv(['class'=>'row resume-header-wrapper']);
	    $h->odiv(['class' => 'resume-header', 'class'=>'col-xs-12']);
	    $h->div('Andrew T.Hill', ['class' => 'resume-name']);
	    $info = [
	    	'409 N. Roosevelt Bloomington, IN 47408',
	    	'(812)323-1590',
	    	$h->rtn('email', ['athill@iu.edu'])
	    ];
	    $links = [
	    	$h->rtn('a', ['http://andyhill.us']),
	    	$h->rtn('a', ['https://github.com/athill/']),
	    ];
	    foreach ([$info, $links] as $section) {
	    	$h->div(implode(' &bull; ', $section), ['class' => 'resume-info']);	
	    }
	    $h->cdiv('/.resume-header');
	    $h->cdiv('/.resume-header-wrapper');
	}

	protected function section($title, $callbackName) {
		global $h;
		$h->odiv(['class' => 'row']);
		$h->div($title, ['class' => 'left-col col-md-2']);

		$h->div($this->callback($callbackName), ['class' => 'right-col col-md-10']);
		$h->cdiv('/.row');
	}

	protected function callback($callbackName)	{
		global $h;
		$h->startBuffer();
		call_user_func([$this, $callbackName]);
		return $h->endBuffer();
	}

	//// sections
	protected function objective() {
		global $h;
		$h->tnl('To apply and expand my computer skills in a challenging position. Specifically interested in writing code, the web, open source software, and network technologies.');
	}

	protected function education() {
		global $h;
		$categories = [
			[
				'title' => '<strong>Coursera</strong>, <a href="https://www.coursera.org/" target="_blank">https://www.coursera.org/</a>',
				'entries' => [
					[
						'title' => 'Linear Algebra through C.S. Applications <a href="http://andyhill.us/resume/matrix_cert.pdf" target="_blank">With Distinction</a>',
						'date' => 'September 2013'
					],
					[
						'title' => 'Software Engineering for Software as a Service (Part I) 
       						 <a href="http://andyhill.us/resume/saas_cert.pdf" target="_blank">1917.3/2126</a>',
						'date' => 'March 2012'
					],
				]
			],
			[
				'title' => '<strong>Indiana University</strong>, Bloomington, IN',
				'entries' => [
					[
						'title' => 'Graduate course: Computer Networks 4.0/4.0',
						'date' => 'December 2007'
					],
					[
						'title' => 'Unix Systems Support Group Unix Certification',
						'date' => 'August 2003'
					],
					[
						'title' => 'Bachelor of Science in Computer Science GPA since returning: 3.5/4.0',
						'date' => 'May 2003'
					],
					[
						'title' => 'Completed coursework in Anthropology GPA 3.2/4.0',
						'date' => '1989-1992'
					],
				]
			],	
		];

		foreach ($categories as $category) {			
			$this->educationCategory($category['title'], $category['entries']);
		}
	}

	public function computerSkills() {
		global $h;
		$skillsets = [
			['title' => 'Languages', 
				'items' => ['Java', 'JavaScript', 'ColdFusion', 'PHP', 'Apache Ant', 'C/C++', 'Bash', 'Python', 'Ruby', 'C#', 'Scheme', 'Perl']
			],
			['title' => 'Web',
				'items' => ['Spring Boot', 'Laravel', 'React', 'Redux', 'Webpack', 'HTML5', 'jQuery', 'CSS3/Sass', 'D3.js']
			],
			['title' => 'Data',
				'items' => ['Elasticsearch', 'MongoDB', 'Oracle', 'MySQL', 'SQL Server', 'LDAP/ADS', 'JSON', 'XML', 'XPath']
			]
		];
		$h->oul(['class' => 'skillsets indent0']);
		foreach ($skillsets as $skillset) {
			$h->li('<strong>'.$skillset['title'].':</strong> '.implode(', ', $skillset['items']));
		}
		$h->cul();
	}

	protected function workExperience() {
		global $h;
		$h->odiv(['class' => 'work-experience']);
		$jobs = [
			[
				'department' => 'Enterprise Systems Integration Middleware',
				'title' => 'Senior Programmer/Systems Analyst',
				'dates' => '2014-Present',
				'content' => 'As a member of a small team, maintain Kuali Rice implementation including updatating document search to use an Elasticsearch back end and build and maintain other sites which use Spring Boot, React, and Redux. We strive for continuos integration (Bamboo), practice scrum, and believe in testing, linting, peer-review and other best practices. We also maintain various services for other enterprise services, including a Nexus repository for Java and NPM artifacts, an integrated deployment process, and Elasticsearch as a service.'
			],		
			[
				'department' => 'University Student Services and Systems',
				'title' => 'Senior Programmer/Systems Analyst',
				'dates' => '2005-2014',
				'content' => 'Maintained three extensive web sites in ColdFusion and PHP with Oracle, SQL Server, and MySQL back ends using jQuery and AJAX technologies. Build frameworks in both ColdFusion and PHP based on convention over configuration principles, allowing overrides at directory or page level, including a system to easily include jQuery plugins where needed. The frameworks have toolsets to ease sending emails, interacting with database and LDAP data stores, generating HTML, rendering and processing forms, and other common tasks. Initiated using version control (Git).'
			],
			[
				'department' => 'Center for Survey Research',
				'title' => 'Web Programmer',
				'dates' => '2004-2005',
				'content' => 'Implemented surveys on the web using ColdFusion/SQL Server, 	created interfaces for survey sponsors to view and interact 
				        with acquired data, and maintained external and internal web sites including internal survey tracking. Modularized survey programming to improve consistency of display and function, simplified and streamlined 
				        rendering and handling of survey questions. Implemented a primitive, but functional, time-keeping system.'
			],
			[
				'department' => 'University Information Technology Services',
				'title' => 'Computer Lab Monitor, Help Desk',
				'dates' => '2000-2004',
				'content' => 'Started as a computer lab consultant, was promoted to Support Staff position in May of 2002, which entailed supervising 140 consultants, acting as go-between to 
				    UITS higher-ups, and helping with difficult customer issues. Also contributed functionality to internal website using Perl.
				    As a Support Center Consultant (2003), Assisted walk-in and telephone customers with computer related problems including networking, hardware, authentication, and security issues. Continued in Support Staff Position.'
			],

			// [
			// 	'department' => '',
			// 	'title' => '',
			// 	'dates' => '',
			// 	'content' => ''
			// ],
		];
		$this->workplace('<strong>Indiana University</strong>, Bloomington, IN', $jobs);
		$jobs = [
			[
				'department' => '',
				'title' => 'Prep Cook, Line Cook, Dishwasher, Server, Busser',
				'dates' => '1986-2002',
				'content' => 'Acquired work ethic, learned teamwork and interpersonal skills'
			],
		];
		$this->workplace('<strong>Various Restaurants</strong>, Bloomington and Indianapolis, IN', $jobs);
		$h->cdiv('/.work-experience');
	}

	protected function references() {
		global $h;
		$h->tnl('Available upon request.');
	}



	//// helpers
	private function workplace($title, $jobs) {
		global $h;
		$h->div($title);
		foreach ($jobs as $job) {
			$indent = 1;
			if (isset($job['department']) && $job['department']) {
				$h->div('<em>'.$job['department'].'</em>', ['class' => 'clear indent'.$indent]);	
				$indent++;
			}
			$h->odiv(['class' => 'title-date indent'.$indent]);
			$this->titleDate($job['title'], $job['dates']);
			$h->cdiv('./title-date');
			$h->div($job['content'], ['class' => 'indent3 clear']);
		}		
	}

	private function educationCategory($title, $entries) {
		global $h;
		$h->div($title, ['class' => 'education-category-title']);
		foreach ($entries as $entry) {
			$this->titleDate($entry['title'], $entry['date']);
		}
	}

	private function titleDate($title, $date, $leftWidth=9) {
		global $h;
		$rightWidth = 12 - $leftWidth;
		$h->odiv(['class' => 'title-date indent1 row']);
		$h->div($title, ['class' => 'title col-xs-'.$leftWidth]);
		$h->div($date, ['class' => 'date col-xs-'.$rightWidth]);
		$h->cdiv('/.title-date');		
	}
}