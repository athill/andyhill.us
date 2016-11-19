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
				'items' => ['ColdFusion', 'PHP', 'Java', 'Apache Ant', 'C++', 'Python', 'Ruby', 'C#', 'Flex', 'C', 'Scheme', 'Perl']
			],
			['title' => 'Web',
				'items' => ['HTML5', 'JavaScript/XHR/jQuery', 'CSS3/Sass', ' Rails', 'Django', 'D3.js']
			],
			['title' => 'Data',
				'items' => ['Oracle', 'SQL Server', 'MySQL', 'LDAP/ADS', 'JSON', 'XML', 'XPath']
			]
		];
		$h->oul(['class' => 'indent0']);
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
				'department' => 'University Student Services and Systems',
				'title' => 'Senior Programmer/Systems Analyst',
				'dates' => '2005-Present',
				'content' => '    <ul class="clear">
			        <li>Maintain three web sites in ColdFusion/IIS/Sql Server-Oracle and one in PHP/Apache/MySQL-Oracle environments, as well as several SharePoint Master Pages</li>
			        <li>Built templating infrastructure in both ColdFusion and PHP to maintain aesthetic consistency while 
			        allowing granular flexibility. Includes a features manager to include appropriate JavaScript and CSS files when various jQuery plugins and other bundled client side scripts and styles are required.</li>
			        <li>Built extensive toolsets in both ColdFusion and PHP to normalize API interaction, group common tasks, and provide pre-event control such as sending email to the authenticated user rather than the original recipients in test environments. Toolkits include sending email, ADS/LDAP and database interactions, creating and reading 
			        .CSV files, and HTML utilities.</li>
			        <li>Led project creating web form infrastructure which centralizes settings for rendering, updating, securing, and validating (both client and server side) web forms while offering flexibility in form layout and database updates.</li>
			    </ul>'
			],
			[
				'department' => 'Center for Survey Research',
				'title' => 'Web Programmer',
				'dates' => '2004-2005',
				'content' => 'Implemented surveys on the web using ColdFusion/SQL Server, 	created interfaces for survey sponsors to view and interact 
				        with acquired data, and maintained external and internal web sites including internal survey tracking. 
				        <ul>
				        <li>Modularized survey programming to improve consistency of display and function, simplified and streamlined 
				        rendering and handling of survey questions.</li>
				        <li>Implemented a primitive, but functional, time-keeping system</li>
				    </ul>'
			],
			[
				'department' => 'University Information Technology Services',
				'title' => 'Computer Lab Monitor, Phone/Walk-in Support',
				'dates' => '2000-2004',
				'content' => 'Started as a computer lab consultant, was promoted to Support Staff position in May of 2002, which entailed supervising 140 consultants, updating internal web pages, acting as go-between to 
				    UITS higher-ups, and helping with difficult customer issues.
				    <ul>
				        <li>Improved user-interface and efficiency of online FAQ (Perl).</li>
				        <li>Created online interface to communicate lab supply needs between support staff members (Perl).</li>
				    </ul>    
				    As Support Center Consultant(2003), Assisted walk-in and telephone customers with computer related problems including networking, hardware, authentication, and security issues. Continued in Support Staff Position.'
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