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
			// ['title' => '', 'callbackName' => ''],
		];

		foreach ($sections as $section) {
			$this->section($section['title'], $section['callbackName']);
		}

		// $h->cdiv('/#resume');
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
		return $h->tnl('    <ul class="indent0">
        <li><strong>Languages:</strong> ColdFusion, PHP, Java, Apache Ant, C++, Python, Ruby, C#, Flex, C, Scheme, Perl</li>
        <li><strong>Web:</strong> HTML5, JavaScript/XHR/jQuery, CSS3/Sass,  Rails, Django, D3.js</li>
        <li><strong>Data:</strong> Oracle, SQL Server, MySQL, LDAP/ADS, JSON, XML, XPath</li>
    </ul>');
	}

	//// helpers
	private function educationCategory($title, $entries) {
		global $h;
		$h->div($title, ['class' => 'education-category-title']);
		foreach ($entries as $entry) {
			$h->odiv(['class' => 'title-date indent1 row']);
			$h->div($entry['title'], ['class' => 'title col-xs-9']);
			$h->div($entry['date'], ['class' => 'date col-xs-3']);
			$h->cdiv('/.title-date');
		}
	}	
}