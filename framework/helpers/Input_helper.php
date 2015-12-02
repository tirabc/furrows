<?php

class Input
{

    static function filter( $args , $keys )
    {
        global $error;
        $array = array();
        foreach( $keys as $i => $v )
        {
            if( array_key_exists( $v , $args ) && !empty( $args[ $v ] ) )
            {
                $array[ $v ] = $args[ $v ];
            }
            else
            {
                return false;
            }
        }

        return $array;

    }

    static function sanitize( $field )
    {
        return htmlentities( htmlspecialchars( $field ) );
    }

    static function escape_mysql( $field )
    {
        return htmlentities( mysqli_real_escape_string( $field ) );
    }

    static function hash( $field )
    {
        return md5( $field );
    }

}
?>
