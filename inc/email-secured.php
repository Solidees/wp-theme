<?php
/**
 * Librairie pour protéger les emails mis dans le contenu
 *
 * @author Laurent Chedanne <laurent@chedanne.pro>
 * @since 1.0
 */


/**
 * Transform email information in link to contact
 *
 * @param string $content
 */
function solidees_hide_emails($content) {
	$matches = array();
	if (preg_match_all('/([a-z\.-]+)@([a-z\.-]+)\.([a-z]{2,})/i', $content, $matches)) {
		$html_email = array();
		foreach($matches[0] as $i => $email) {
			$html_email[$i] = '<a href="#" onclick="this.innerHTML = \''.$matches[1][$i].'\'+\'@\'+\''.$matches[2][$i].'\'+\'.\'+\''.$matches[3][$i].'\'; return false;" class="email">'.__("Voir l'email", "stic_email_secured").'</a>';
			$content = str_replace($email, $html_email[$i], $content);
		}
	}
	return $content;
}
add_filter( 'the_content', 'solidees_hide_emails' );