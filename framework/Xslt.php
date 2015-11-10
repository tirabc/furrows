<?php

class Xslt extends View implements iRenderView
{
    protected $html;
    protected $xml_doc;
    protected $xsl_doc;
    
    public function __construct(){}
    
    public function render()
    {
        if( empty( $this->xml_doc ) )
        {
            throw new Exception( "Charger un xml");
        }
        if( empty( $this->xsl_doc ) )
        {
            throw new Exception( "Charger un xsl");
        }
    
        // Proc
        $proc = new XSLTProcessor();
        $proc->importStylesheet( $this->xsl_doc );
        $this->html = $proc->transformToXML( $this->xml_doc );
        
        echo $this->html;
    }
    
    public function load_xml_data( $data )
    {
        $this->xml_doc = new DOMDocument();
        $this->xml_doc->loadXML( $data );

    }
    
    public function load_xml_file( $url )
    {
        $this->xml_doc = new DOMDocument();
        $this->xml_doc->load( $url );
    }    
    
    public function load_xsl_file( $url )
    {
        $this->xsl_doc = new DOMDocument();
        $this->xsl_doc->load( $url );
    }
    
}

?>