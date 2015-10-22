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
        // format any errors and display them before the form
        $message = '';
        if (count($this->errors) > 0) {
        foreach ($this->errors as $booboo)
            $message .= $booboo . BR;
        }
        $this->data['message'] = $message;
        
        //Display the form
        $this->data['fid'] = makeTextField('ID#', 'id', $quote->id, "Unique quote identifier, 
            system-assigned", 10, 10, true);
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who, "", 64);
        $this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug, "", 64);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what, "", 300);
        $this->data['pagebody'] = 'quote_edit';
        
        $this->data['fsubmit'] = makeSubmitButton('Process Quote', "Click here to validate the quotation data", 'btn-success');
        
        $this->render();
    }
    
    //process a quotation edit
    function confirm() {
        $record = $this->quotes->create();
        // Extract submitted fields
        $record->id = $this->input->post('id');
        $record->who = $this->input->post('who');
        $record->mug = $this->input->post('mug');
        $record->what = $this->input->post('what');
        
        // validation
        if (empty($record->who))
            $this->errors[] = 'You must specify an author.';
        if (strlen($record->what) < 20)
            $this->errors[] = 'A quotation must be at least 20 characters long.';
        
        // redisplay if any errors
        if (count($this->errors) > 0) {
            $this->present($record);
            return; // make sure we don't try to save anything
        }
        
        // Save stuff
        if (empty($record->id)) 
            $this->quotes->add($record);
        else $this->quotes->update($record);
            redirect('/admin');
    }
}

/* End of file Admin.php */
/* Location: application/controllers/Admin.php */