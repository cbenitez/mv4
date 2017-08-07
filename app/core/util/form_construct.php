<?php
function input( $params ){
    
    $params = @json_decode( $params, true );

    if( count( $params ) > 0 && is_array( $params ) ):

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

        if( !empty( $params['pattern'] ) ):
            $pattern = 'pattern=".{' . $params['pattern'] . '}"';
        endif;

        if( !empty( $params['label'] ) ):
            $label = $params['label'];
        endif;

        if( !empty( $params['name'] ) ):
            $name = $params['name'];
        else:
            $name = slugit( $label );
        endif;

        if( !empty( $params['placeholder'] ) ):
            $placeholder = 'placeholder="' . $params['placeholder'] . '"';
        endif;

        if( number( $params['maxlength'] ) > 0 ):
            $maxlength = 'maxlength="' . $params['maxlength'] . '"';
        endif;

        if( number( $params['step'] ) > 0 ):
            $step = 'step="' . $params['step'] . '"';
        endif;

        if( !empty( $params['max'] ) ):
            $max = 'max="' . $params['max'] . '"';
        endif;

        if( !empty( $params['min'] ) ):
            $min = 'min="' . $params['min'] . '"';
        endif;

        if( $params['autocomplete'] == "off" ) :
            $autocomplete = 'autocomplete="off"';
        endif;

        if( !empty( $params['class'] ) ):
            $class = $params['class'];
        endif;

        if( $params['required'] ):
            $required = 'required';
        endif;

        if( $params['disabled'] ):
            $disabled = 'disabled';
        endif;

        if( $params['readonly'] ):
            $readonly = 'readonly';
        endif;

        if( !empty( $params['value'] ) ):
            $value = 'value="' . $params['value'] . '"';
        endif;
        
    endif;

    $input = 
    '<div class="form-group">' .
        '<label for="' . $name . '">' . $label . '</label>' .
        '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="form-control ' . $class . '" ' .  $step . ' ' . $placeholder . ' ' . $required . ' ' . $readonly . ' ' . $autocomplete . ' ' . $pattern . ' ' . $disabled . ' ' . $value . ' ' . $min . ' ' . $max . ' ' . $maxlength . '>' .
        '<div class="help-block with-errors"></div>' . 
    '</div>';

    return $input;
}

function textarea( $params ){

    $params = @json_decode( $params, true );

    if( count( $params ) > 0 && is_array( $params ) ):

        if( $params['placeholder'] ):
            $placeholder = 'placeholder="' . $params['placeholder'] . '"';
        endif;

        if( number( $params['rows'] ) > 0 ):
            $rows = 'rows="' . $params['rows'] . '"';
        endif;

        if( number( $params['cols'] ) > 0 ):
            $cols = 'cols="' . $params['cols'] . '"';
        endif;

        if( $params['label'] ):
            $label = $params['label'];
        endif;

        if( $params['wrap'] ):
            $wrap = $params['wrap'];
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

        if( number( $params['maxlength'] ) > 0 ):
            $maxlength = 'maxlength="' . $params['maxlength'] . '"';
        endif;
    
        if( $params['readonly'] ):
            $readonly = 'readonly';
        endif;

        if( !empty( $params['value'] ) ):
            $value = 'value="' . $params['value'] . '"';
        endif;

    endif;

    $textarea = 
    '<div class="form-group">' . 
        '<label for="'.$name.'">'.$label.'</label>' . 
        '<textarea class="form-control ' . $class . '" name="' . $name . '" id="' . $name . '" ' . $required . ' ' . $pattern . ' ' . $placeholder . ' ' . $wrap . ' ' . $disabled . ' ' . $cols . ' ' . $rows . ' ' . $readonly . '>' . $value . '</textarea>' . 
        '<div class="help-block with-errors"></div>' . 
    '</div>';

    return $textarea;
}

function select( $params ){

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

    $select =
    '<div class="form-group">' .
        '<label for="'.$name.'">'.$label.'</label>' . 
        '<select class="form-control ' . $class . '" name="' . $name . '" id="' . $name . '" ' . $required . ' ' . $disabled . '>' .
            '<option value="">Seleccionar/option>' .
            $options .
        '</select>' .
        '<div class="help-block with-errors"></div>' . 
    '</div>';
    
    return $select;
}

function checkbox( $params ){

    $params = @json_decode( $params, true );

    if( count( $params ) > 0 && is_array( $params ) ):

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

    $checkbox = 
    '<div class="checkbox">' .
        '<label>' .
            '<input type="checkbox" name="' . $name . '" id="' . $name . '" class="form-control ' . $class . '" ' . $required . ' ' . $disabled . ' ' . $value . '>' . $label .
        '</label>' .
        '<div class="help-block with-errors"></div>' .
    '</div>';

    return $checkbox;
}

function radio( $params ){
    
    $params = @json_decode( $params, true );

    if( count( $params ) > 0 && is_array( $params ) ):

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

    $radio = 
    '<div class="radio">' .
        '<label>' .
            '<input type="radio" name="' . $name . '" id="' . $name . '" class="form-control ' . $class . '" ' . $required . ' ' . $disabled . ' ' . $value . '>' . $label .
        '</label>' .
        '<div class="help-block with-errors"></div>' .
    '</div>';

    return $radio;
}

function upload( $params ){

    $params = @json_decode( $params, true );

    if( count( $params ) > 0 && is_array( $params ) ):

        if( $params['label'] ):
            $label = $params['label'];
        endif;

        if( $params['name'] ):
            $name = $params['name'];
        else:
            $name = slugit( $label );
        endif;

        if( $params['help'] ):
            $help = $params['help'];
        endif;

        if( $params['required'] ):
            $required = 'required';
        endif;

        if( $params['disabled'] ):
            $disabled = 'disabled';
        endif;

        if( $params['multiple'] ):
            $multiple = 'multiple';
        endif;

        if( $params['accept'] ):
            $accept = 'accept="' . $params['accept'] . '"';
        endif;
    
    endif;

    $upload =
    '<div class="form-group">' .
        '<label for="' . $name . '">' . $label . '</label>' .
        '<input type="file" name="' . $name . '" id="' . $name . '" ' . $multiple . ' ' . $required . ' ' . $disabled . ' ' . $accept . '>' .
        '<p class="help-block">' . $help . '</p>' .
    '</div>';

    return $upload;
}