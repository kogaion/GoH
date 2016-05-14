<?php

class EmailNewsletter extends CI_Controller
{
    protected $data = [];

    public function html() {
        echo $this->generateHtml();
    }

    public function email() {
        $html    = $this->generateHtml();
        $this->load->library('email');

        $this->email->from(NEWSLETTER_EMAIL_FROM, 'GoH Team');
        $this->email->to(NEWSLETTER_EMAIL_TO);

        $this->email->subject('Game Of Codes - Last week news');
        $this->email->message($html);

        $this->email->send();
    }

    protected function generateHtml()
    {
        $this->load->model('NewsletterModel');
        $this->load->model('TopModel');

        $generalLeaderBoard = $this->NewsletterModel->getAllTimeBoard();
        $last7Days = new DateTime();
        $last7Days->modify('-7 day');

        $today = new DateTime();
        $today->modify('+1 day'); //@todo modify to -1

        $last7DaysUserEvolution = $this->TopModel->getTopUsers(
            $last7Days->format('Y-m-d 00:00:00'),
            $today->format('Y-m-d 00:00:00')
        );

        $last7DaysProjectEvolution = $this->TopModel->getTopProjects(
            $last7Days->format('Y-m-d 00:00:00'),
            $today->format('Y-m-d 00:00:00')
        );

        $data = [
            'allTime'           => $generalLeaderBoard,
            'userEvolution'     => $last7DaysUserEvolution,
            'projectsEvolution' => $last7DaysProjectEvolution,
        ];
        return $this->load->view('email/newsletter', $data, true);
    }

}