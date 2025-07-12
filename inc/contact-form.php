<?php 
/**
 * All functions relative to contact form
 *
 * @package Bonne-Ambiance
 */

/**
 * Generate contact form message
 *
 * @param string $type success|error type of message.
 * @param string $message_id an id to get the right text.
 * @return string $out HTML message
 */
function ba_form_generate_response( $type, $message_id ) {

	$out      = '';
	$messages = array(
		'not_human'       => __( 'Human verification incorrect.', 'Bonne-Ambiance' ),
		'missing_content' => __( 'Please supply all information.', 'Bonne-Ambiance' ),
		'email_invalid'   => __( 'Email Address Invalid.', 'Bonne-Ambiance' ),
		'message_unsent'  => __( 'Message was not sent. Try Again.', 'Bonne-Ambiance' ),
		'message_sent'    => __( 'Thanks! Your message has been sent.', 'Bonne-Ambiance' ),
	);

	if ( isset( $messages[ $message_id ] ) ) {
		if ( 'success' === $type ) {
			$out .= "<div class='success'>{$messages[ $message_id ]}<a href='#' class='close'></a></div>";
		} else {
			$out .= "<div class='warning'>{$messages[ $message_id ]}<a href='#' class='close'></a></div>";
		}
	}
	return $out;
}
/**
 * Get contact form user input and send email
 */
function ba_form_process_mail() {
	$data              = array();
	$response          = array();
	$data['name']      = ( isset( $_POST['message_name'] ) ) ? sanitize_user( wp_unslash( $_POST['message_name'] ) ) : null;
	$data['email']     = ( isset( $_POST['message_email'] ) ) ? sanitize_user( wp_unslash( $_POST['message_email'] ) ) : null;
	$data['message']   = ( isset( $_POST['message_text'] ) ) ? sanitize_user( wp_unslash( $_POST['message_text'] ) ) : null;
	$data['add_first'] = ( isset( $_POST['add_first'] ) ) ? intval( $_POST['add_first'] ) : false;
	$data['add_secnd'] = ( isset( $_POST['add_secnd'] ) ) ? intval( $_POST['add_secnd'] ) : false;


	$subject = __( 'Someone sent a message from ', 'Bonne-Ambiance' );
	$to      = get_option( 'admin_email' );
	$subject = $subject . get_bloginfo( 'name' );
	$message = $data['message'] . "\r\n" . $data['name'];
	$headers = 'From: ' . $data['email'] . "\r\n" . 'Reply-To: ' . $data['email'] . "\r\n";

	if ( isset( $_POST['ba_form_process_mail_nonce'] ) &&
		wp_verify_nonce( sanitize_user( wp_unslash( $_POST['ba_form_process_mail_nonce'] ) ), 'ba_form_process_mail' ) &&
		isset( $_POST['submit'] ) &&
		empty( $_POST['name'] ) &&
		empty( $_POST['email'] ) &&
		empty( $_POST['website'] )
	) {
		if ( ! filter_var( $data['email'], FILTER_VALIDATE_EMAIL ) ) {
			
			$response[] = array(
				'type' => 'error',
				'id'   => 'email_invalid',
			);

		} else {

			if ( 10 !== $data['add_first'] + $data['add_secnd'] ) {

				$response[] = array(
					'type' => 'error',
					'id'   => 'not_human',
				);
			} else {
				if ( empty( $data['name'] ) || empty( $data['message'] ) ) {
					$response[] = array(
						'type' => 'error',
						'id'   => 'missing_content',
					);
				} else {
					$sent = wp_mail( $to, $subject, wp_strip_all_tags( $message ), $headers );
					$sent = true;
					if ( $sent ) {
						$response[] = array(
							'type' => 'success',
							'id'   => 'message_sent',
						);
					} else {
						$response[] = array(
							'type' => 'error',
							'id'   => 'message_unsent',
						);
					}
				}
			}
		}
	} elseif ( isset( $_POST['submit'] ) ) {
		$response[] = array(
			'type' => 'error',
			'id'   => 'missing_content',
		);
	}
	return array(
		'data'     => $data,
		'response' => $response,
	);
}
/**
 * Fire contact form
 *
 * @param string $url return contact HTML markup.
 */
function ba_get_form_markup( $url ) {

	$returned       = ba_form_process_mail();
	$data           = $returned['data'];
	$response       = $returned['response'];
	$add_first_elem = intval( wp_rand( 0, 9 ) );

	if ( ! empty( $response ) ) {
		foreach ( $response as $notification ) {
			if ( isset( $notification['type'], $notification['id'] ) ) {
				echo wp_kses_post( ba_form_generate_response( $notification['type'], $notification['id'] ) );
			}
		}
	}
	if ( empty( $response[0] ) || 'message_sent' !== $response[0]['id'] ) : 
		?>
		<form action="<?php echo esc_url( $url ); ?>" method="post"  class="contact">
			<h2><?php _e('Email',  'Bonne-Ambiance' ); ?></h2>

			<?php wp_nonce_field( 'ba_form_process_mail', 'ba_form_process_mail_nonce', true, true ); ?>

			<?php /** Honey pot field  */ ?>
			<label class="pot" for="name">Name (please leave this field empty)</label>
			<input class="pot" id="name" type="text" name="name"	autocomplete="off" value="" placeholder="Your name here">

			<label class="pot" for="email">Name (please leave this field empty)</label>
			<input class="pot" id="email" type="email" name="email" autocomplete="off" value="" placeholder="Your email here">

			<label class="pot" for="website">Name (please leave this field empty)</label>
			<input class="pot" id="website" type="url" name="website" autocomplete="off" value="" placeholder="Your website here">

			<span class="input">
				<input 
					type="text" class="input__field"
					name="message_name" id="message_name"
					placeholder="<?php echo esc_html__( 'Name *', 'Bonne-Ambiance' ); ?>"
					value="<?php echo isset( $data['name'] ) ? esc_html( $data['name'] ) : ''; ?>" required>
			</span>

			<span class="input">
				<input 
					type="text" class="input__field"
					name="message_email" id="message_email"
					placeholder="<?php echo esc_html__( 'Email *', 'Bonne-Ambiance' ); ?>"
					value="<?php echo isset( $data['email'] ) ? esc_html( $data['email'] ) : ''; ?>" required>
			</span>

			<span class="input textarea-input">
				<textarea 
					type="text" 
					name="message_text" 
					id="message_text"  
					class="input__field" 
					rows="7" 
					placeholder="<?php echo esc_html__( 'Message *', 'Bonne-Ambiance' ); ?>"
					required
				><?php echo isset( $data['message'] ) ? esc_html( $data['message'] ) : ''; ?></textarea>
			</span>

			<span class="input anti-spambot-input">
				<input type="hidden" name="add_first" value="<?php echo intval( $add_first_elem ); ?>">
				<p>
					<?php echo intval( $add_first_elem ); ?>
					+
					<input type="number" name="add_secnd" value="" placeholder="*" required>
					= 
					10
				</p>
			</span>

			<span class="input">
				<label class="input__label">
					<?php echo esc_html__( '* : require field', 'Bonne-Ambiance' ); ?>
				</label>

				<button type="submit" name="submit" class="button">
					<?php echo esc_html__( 'send', 'Bonne-Ambiance' ); ?>
				</button>
			</span>

		</form>


		<?php 
	endif;

}

