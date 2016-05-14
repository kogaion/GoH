<?php

class EmailNewsletter extends CI_Controller
{
    protected $data = [];

    public function index() {
        echo $this->generateHtml();
    }

    public function email() {
        $html    = $this->generateHtml();
        $this->load->library('email');

        $this->email->from('ionut.codreanu@avangate.com', 'GoH Team');
        $this->email->to('ionut.codreanu@avangate.com');

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
            $today->format('Y-m-d 00:00:00'),
            10
        );

        $data = [
            'allTime'           => $generalLeaderBoard,
            'userEvolution'     => $last7DaysUserEvolution,
            'projectsEvolution' => $last7DaysProjectEvolution,
            'base_url'          => base_url('EmailNewsletter'),

        ];

        return $this->load->view('email/newsletter', $data, true);
    }

}