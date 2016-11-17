<?php

class Resume {


	public function render() {
		global $h;
		$h->odiv(['id' => 'resume', 'class' => 'container']);
		$this->header();
		$sections = [
			['title' => 'Objective', 'callbackName' => 'objective'],
			// ['title' => 'Education', 'callbackName' => 'education'],
			// ['title' => '', 'callbackName' => ''],
		];

		foreach ($sections as $section) {
			$this->section($section['title'], $section['callbackName']);
		}

		// $h->cdiv('/#resume');
	}

	public function header() {
	    global $h;
	    $h->odiv(['id' => 'header-wrapper', 'class'=>'row']);
	    $h->odiv(['id' => 'header', 'class'=>'col-xs-12']);
	    $h->div('Andrew T.Hill', ['id' => 'name']);
	    $h->div('409 N. Roosevelt Bloomington, IN 47408 &bull; (812)323-1590 &bull; athill@indiana.edu &bull; 
	        <a href="http://andyhill.us">http://andyhill.us</a> &bull; <a href="https://github.com/athill/">https://github.com/athill/</a>', ['id' => 'info']);

	    $h->cdiv('/#header');
	    $h->cdiv('/#header-wrapper');
	}

	protected function section($title, $callbackName) {
		global $h;
		$h->odiv(['class' => 'row']);
		$h->div($title, ['class' => 'left-col col-md-2']);

		$h->div($this->callback($callbackName), ['class' => 'left-col col-md-10']);
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
		return;
		global $h;
		$h->tnl('<strong>Coursera</strong>, <a href="https://www.coursera.org/" target="_blank">https://www.coursera.org/</a>
    </div>
    <div class="title-date indent1">
        <div class="title">
        Linear Algebra through C.S. Applications
        <a href="http://andyhill.us/resume/matrix_cert.pdf" target="_blank">With Distinction</a>
        </div>
        <div class="date">
        September 2013
        </div>
    </div>    
    <div class="title-date indent1">
        <div class="title">
        Software Engineering for Software as a Service (Part I) 
        <a href="http://andyhill.us/resume/saas_cert.pdf" target="_blank">1917.3/2126</a>
        </div>
        <div class="date">
        March 2012
        </div>
    </div>
    <div class="clear">
    <div class="row">
    <strong>Indiana University</strong>, Bloomington, IN
    </div>
    <div class="title-date indent1">
        <div class="title">
        Graduate course: Computer Networks 4.0/4.0
        </div>
        <div class="date">
        December 2007
        </div>
    </div>
    <div class="title-date indent1">
        <div class="title">
        Unix Systems Support Group Unix Certification
        </div>
        <div class="date">
        August 2003
        </div>
    </div>
    <div class="title-date indent1">
        <div class="title">
        Bachelor of Science in Computer Science GPA since returning: 3.5/4.0 
        </div>
        <div class="date">
        May 2003
        </div>
    </div>
    <div class="title-date indent1">
        <div class="title">
        Completed coursework in Anthropology GPA 3.2/4.0
        </div>
        <div class="date">
        1989-1992
        </div>
    </div>
	<div class="content indent1">
    <div class="indent-after-first-line">
    <strong>Relevant Coursework:</strong> Software Engineering, Programming Languages, Databases, Data Structures, Operating Systems, Compilers, Networking, Graphics.');
	}
}