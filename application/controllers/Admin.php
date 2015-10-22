<?php

/**
 * Show the quotes and allow them to be editing.
 * 
 * controllers/Admin.php
 *
 * ------------------------------------------------------------------------
 */
class Admin extends Application {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('formfields');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
        
        $this->data['title'] = 'Quotations Maintenance';
        $this->data['quotes'] = $this->quotes->all();
        $this->data['pagebody'] = 'admin_list'; 
        $this->render();
        /*$this->data['pagebody'] = 'justone';    // this is the view we want shown
        $choice = rand(1, $this->quotes->size());
        $this->data = array_merge($this->data, (array) $this->quotes->get($choice));
        
        //load the star rating system
        $this->caboose->needed('jrating','hollywood');
        $this->data['average'] = ($this->data['vote_count'] > 0) ? 
            ($this->data['vote_total'] / $this->data['vote_count']) : 0;
        $this->render();*/
    }
    
    //Adds a new quotation
    function add() {
        $quote = $this->quotes->create();
        $this->present($quote);
    }
    
    
    // Present a quotation for adding/editing
    function present($quote) {
        $this->data['fid'] = makeTextField('ID#', 'id', $quote->id);
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
        $this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what);
        $this->data['pagebody'] = 'quote_edit';
        $this->render();
    }
}

/* End of file Admin.php */
/* Location: application/controllers/Admin.php */