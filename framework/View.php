<?php

/**
 * View
 *
 * @author christian barras
 */
class View
{

    private $vars;
    private $blocks;
    private $text;

    /*
     * __construct( $dir , $file )
     * @note : permet d'ouvrir un template et d'initialiser l'objet avec le
     * contenu
     * @param : $dir string
     * @param : $file string
     * @return : void
     */
    public function __construct( $dir , $file )
    {
        // Lever l'exception 'Répertoire incorrect'
        if ( !is_dir( $dir ) )
		{
    		throw new Exception ( 'Le parametre ' . $dir . ' n\'est pas un repertoire' );
		}

        // Lever l'exception 'Fichier incorrect'
		if ( !is_file( $dir.'/'.$file ) )
		{
			throw new Exception ( 'Le parametre ' . $file . ' n\'est pas un fichier' );
		}

        // On ouvre le template
		$template = fopen ( $dir.'/'.$file , 'r' );

        // Lever l'exception 'Erreur à l'ouverture du template'
        if ( !$template )
		{
			throw new Exception ( 'Erreur a l\'ouverture du template' );
		}

        // On récupère le contenu du template
		while ( !feof ( $template ) )
		{
			// On récupère une ligne
			$this->text .= fgets ( $template , 255 );
		}

        // On ferme le template
		fclose ( $template );

	}

    /*
     * set_var( $name , $value )
     * @note : permet d'initialiser une variable de template
     * @param : $name string
     * @param : $value mixed
     * @return : void
     */
    public function set_var( $name , $value )
    {
        // Lever l'exception 'Le parametre passé est un tableau'
        if ( is_array( $name ) || is_array( $value ) )
		{
            throw new Exception( 'Le parametre pass&eacute; est un tableau !' );
		}
		
        // On initialise l'attribut $vars
		$this->vars[$name] = $value;
    }

    /*
     * set_vars( $array )
     * @note : permet d'initialiser l'ensemble des variables de template
     * @param : $array array
     * @return : void
     */
    public function set_vars( array $array )
    {
        // Lever l'exception 'Le parametre passé n'est pas un tableau'
        if ( !is_array( $array ) )
		{
            throw new Exception ( 'Le parametre pass&eacute; n\'est pas un tableau' );
		}

        // Pour chaque élément du tableau...
		foreach ( $array as $var => $val )
		{
            // ...on initialise l'attribut $vars
            $this->vars[$var] = $val;
		}
    }

    /*
     * set_block( $name , array $vars )
     * @note : permet d'initialiser une variable Block avec un tableau
     * @param : $name string
     * @param : $vars array
     * @return : void
     */
    public function set_block( $name , array $vars )
    {
        // On lève l'exception "Le paramètre passé n'est pas un tableau"
        if ( !is_array ( $vars ) )
        {
            throw new Exception( 'Le parametre passe n\'est pas un tableau' );
        }

		// Ne pas écraser une variable existante
        if ( !isset ( $this->blocks[$name] ) )
        {
            // On crée la variable de template
            $this->blocks[$name] = array ();
        }

        // On initialise la variable de template
        $this->blocks[$name] = $vars;
    }

    /*
     * parse()
     * @note : permet de remplacer les variables de template par leurs valeurs
     * @return : void
     */
    public function parse()
    {
        // BLOCKS
        if ( ! empty( $this->blocks ) )
		{
            // Pour chaque block
            foreach ( $this->blocks as $block_name => $block_content )
            {
                // Contenu du bloc
                $block_ctn = preg_replace ( "#^(.{0,})<!--" . $block_name . ":START-->(.+)<!--" . $block_name . ":END-->(.{0,})$#sU" , "$2" , $this->text );
                $block_txt = '';

                // Pour chaque ligne du bloc
                foreach ( $block_content as $block_row )
                {
                    $block_txt .= $block_ctn;

                    // Pour chaque variable de la ligne
                    foreach ( $block_row as $var => $val )
                    {
                        $block_txt = str_replace ( '{{' . $block_name . ':' . $var . '}}' , $val , $block_txt );
                    }
                }
                $this->text = preg_replace ( "#^(.{0,})<!--" . $block_name . ":START-->(.+)<!--" . $block_name . ":END-->(.{0,})$#sU" , "$1" . $block_txt . "$3" , $this->text );
            }

        }

        // VARIABLES
        if ( ! empty( $this->vars ) )
		{
            foreach ( $this->vars as $var => $val )
            {
                $this->text = str_replace ( '{{' . $var . '}}' , $val , $this->text );
            }
		}

    }

    /*
     * render()
     * @note : afficher la vue
     * @return : void
     */
    public function render()
    {
        echo $this->text;
    }

    /*
     * get_text()
     * @note : retourne le contenu du template
     * @return : string
     */
    public function get_text()
    {
        return $this->text;
    }
}
?>
