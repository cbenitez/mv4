<?php
function input( $params ){
	
	if( !is_array( $params ) ):
		$params = @json_decode( $params, true );
	endif;

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

		if( !empty( $params['val'] ) ):
			$value = 'value="' . $params['val'] . '"';
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

	if( !is_array( $params ) ):
		$params = @json_decode( $params, true );
	endif;

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
			$value = $params['value'];
		endif;

		if( !empty( $params['val'] ) ):
			$value = $params['val'];
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

	if( !is_array( $params ) ):
		$params = @json_decode( $params, true );
	endif;

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

		if( $params['options'] && $params['options'] != 'parent' ):
			$options_arr = explode( ',', $params['options'] );
			if( $params['label_options'] ):
				$label_options_arr = explode( ',', $params['label_options'] );
			endif;
		elseif ( $params['options'] == 'parent' ):
			$obj = new Model;
			$obj->table = $params['fk_table'];
			$prefix = str_replace( '_id', '', $params['fk_field_id'] );
			$where = '"where":"'.$prefix.'_status = 1 AND '.$prefix.'_hidden = 0"';
			$list = $obj->action_select( '{' . $where . '}' );
			$list = json_decode( $list, true );
			if( haveRows( $list ) ):
				foreach( $list as $r ):
					$options_arr[] 			= $r[ $params['fk_field_id'] ];
					$label_options_arr[] 	= $r[ $params['label_options'] ];
				endforeach;
			endif;
		endif;
	
	endif;

	if( is_array( $options_arr ) && count( $options_arr ) > 0 ):
		$c = 0;
		foreach( $options_arr as $value ):
			if( is_array( $label_options_arr ) && count( $label_options_arr ) > 0 ):
				$label_opt = ucfirst( $label_options_arr[ $c ] );
			else:
				$label_opt = ucfirst( $value );
			endif;
			$selected = ( $param['value'] == $value ) ? 'selected' : '';
			$options .= '<option value="' . $value . '" ' . $selected . '>' . $label_opt . '</option>';
			unset( $label_opt );
			$c++;
		endforeach;
		$selected = empty( $selected ) ? 'selected' : '';
	endif;

	$select =
	'<div class="form-group">' .
		'<label for="'.$name.'">'.$label.'</label>' . 
		'<select class="form-control ' . $class . '" name="' . $name . '" id="' . $name . '" ' . $required . ' ' . $disabled . '>' .
			'<option value="">Seleccionar</option>' .
			$options .
		'</select>' .
		'<div class="help-block with-errors"></div>' . 
	'</div>';
	
	return $select;
}

function check_radio( $params ){
	
	if( !is_array( $params ) ):
		$params = @json_decode( $params, true );
	endif;

	if( count( $params ) > 0 && is_array( $params ) ):

		if( $params['type'] ):
			$type = $params['type'];
		endif;
		
		if( $params['label'] ):
			$label = $params['label'];
		endif;

		if( $params['name'] ):
			$name = $params['name'];
		else:
			$name = slugit( $label );
		endif;

		if( $params['value'] ):
			$value = $params['value'];
		endif;

		if( $params['val'] ):
			$val = $params['val'];
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

		if( !$params['inline'] ):
			$inline = $type . '-inline';
		elseif( $params['inline'] == true ):
			$inline = $type . '-inline';
		else:
			$inline = '';
		endif;
		
		if( $params['options'] ):
			$options_arr = explode( ',', $params['options'] );
			if( $params['label_options'] ):
				$label_options_arr = explode( ',', $params['label_options'] );
			endif;
		endif;

	endif;

	if( is_array( $options_arr ) && count( $options_arr ) > 0 ):
		$c = 0;
		$check_radio = '<div class="' . $type . '">' .
				'<strong for="'.$name.'">'.$label.'</strong> ';
		foreach( $options_arr as $value ):
			if( is_array( $label_options_arr ) && count( $label_options_arr ) > 0 ):
				$label_opt = ucfirst( $label_options_arr[ $c ] );
			else:
				$label_opt = ucfirst( $value );
			endif;
			$checked = $params['val'] == $value ? 'checked="checked"' : '';
			$check_radio .= '<label class="' . $inline . '">' .
						'<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="' . $class . '" ' . $disabled . ' ' . $checked . ' value="' . $value . '">' . $label_opt .
					'</label>';
					$c++;
		endforeach;
		$check_radio .= '</div>';
	else:
		$checked = $params['val'] == $value ? 'checked="checked"' : '';
		$check_radio = 
		'<div class="' . $type . '">' .
			'<label>' .
				'<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="' . $class . '" ' . $required . ' ' . $disabled . ' ' . $checked . ' value="' . $value . '">' . $label .
			'</label>' .
			'<div class="help-block with-errors"></div>' .
		'</div>';
	endif;

	return $check_radio;
}

function upload( $params ){

	if( !is_array( $params ) ):
		$params = @json_decode( $params, true );
	endif;

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