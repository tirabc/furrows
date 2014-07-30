<?php

class Campaigns_controller extends Controller
{
    protected $models = array( 'Campaign' );

    public function retrieve( $id = null )
    {
        $campaign_model = new Campaign();

        if( !empty( $id ) )
        {
            $data = $campaign_model->find_by_id( $id );
        }
        else
        {
            $data = $campaign_model->find_all();
        }

        $json = new Json();
        $json->body = $data;
        $json->render(201);
        
    }

}

?>