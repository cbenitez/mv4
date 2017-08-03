<?php
function input( $params ){
    if( count( $params ) > 0 && is_array( $params ) ):

        $params = @json_decode( $params, true );

        switch( $params['type'] ):
            case 'password': 
                $type = "password";
            break;
            case 'datetime': 
                $type = "datetime";
            break;
            case 'datetime-local': 
                $type = "datetime-local";
            break;
            case 'date': 
                $type = "date";
            break;
            case 'month': 
                $type = "month";
            break;
            case 'time': 
                $type = "time";
            break;
            case 'week': 
                $type = "week";
            break;
            case 'number': 
                $type = "number";
            break;
            case 'email': 
                $type = "email";
            break;
            case 'url': 
                $type = "url";
            break;
            case 'search': 
                $type = "search";
            break;
            case 'tel': 
                $type = "tel";
            break;
            case 'color': 
                $type = "color";
            break;
            case 'text': 
            default:
                $type = "text";
        endswitch;

        if( $params['placeholder'] ):
            $placeholder = 'placeholder="' . $params['placeholder'] . '"';
        endif;

        if( $params['pattern'] ):
            $pattern = 'pattern=".{' . $params['pattern'] . '}"';
        endif;

        if( $params['label'] ):
            $label = $params['label'];
        endif;

        if( $params['name'] ):
            $name = $params['name'];
        else:
            $name = slugit( $label );
        endif;

        if( $params['class'] ):
            $class = $params['class'];
        endif;

        if( $params['required'] ):
            $required = 'required';
        endif;

        if( $params['disabled'] ):
            $disabled = 'disabled';
        endif;

        if( $params['value'] ):
            $value = 'value="' . $params['value'] . '"';
        endif;
        
    endif;
    $input = 
    '<div class="form-group">' .
        '<label for="' . $name . '" class="col-sm-2 control-label">' . $label . '</label>' .
        '<div class="col-sm-10">' .
            '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="form-control ' . $class . '" ' . $placeholder . ' ' . $required . ' ' . $pattern . ' ' . $disabled . ' ' . $value . '>' .
            '<div class="help-block with-errors"></div>' . 
        '</div>' .
    '</div>';
    return $input;
}

function textarea( $params ){

    $params = @json_decode( $params, true );

    if( count( $params ) > 0 && is_array( $params ) ):

        if( $params['placeholder'] ):
            $placeholder = 'placeholder="' . $params['placeholder'] . '"';
        endif;

        if( $params['pattern'] ):
            $pattern = 'pattern=".{' . $params['pattern'] . '}"';
        endif;

        if( $params['label'] ):
            $label = $params['label'];
        endif;

        if( $params['name'] ):
            $name = $params['name'];
        else:
            $name = slugit( $label );
        endif;

        if( $params['class'] ):
            $class = $params['class'];
        endif;

        if( $params['required'] ):
            $required = 'required';
        endif;

        if( $params['disabled'] ):
            $disabled = 'disabled';
        endif;
    
    endif;

    $textarea = 
    '<div class="form-group">' . 
        '<label class="col-sm-2 control-label" for="'.$name.'">'.$label.'</label>' . 
        '<div class="col-sm-10">' . 
            '<textarea class="form-control ' . $class . '" name="' . $name . '" id="' . $name . '" ' . $required . ' ' . $pattern . ' ' . $placeholder . ' ' . $disabled . ' rows="7"></textarea>' . 
            '<div class="help-block with-errors"></div>' . 
        '</div>' . 
    '</div>';
    return $textarea;
}

function select( $params ){
    
}

function checkbox( $params ){
    
}

function radio( $params ){
    
}

function upload( $params ){

}