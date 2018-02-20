<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit">
															<p><?php
															global $woocommerce, $post;
															$order = new WC_Order($post->ID);
															$order_id = trim(str_replace('#', '', $order->get_order_number()));
															
															$order = wc_get_order( $order_id );
															$order_data = $order->get_data();
															$order_billing_country = $order_data['billing']['country'];


															?></p>
															<?php if ($order_billing_country == 'NL') { ?>
																<p>Cabman Shop</p>
																<p>Euphoria Software BV<br>
																	<a href="https://www.google.com/url?q=https://maps.google.com/?q%3DWilhelminapark%2B36%2B5041%2BEC%2BTilburg%26entry%3Dgmail%26source%3Dg&amp;source=gmail&amp;ust=1518533252238000&amp;usg=AFQjCNHvvZELbYejUTQoatSaRBPMw9A_iw">
																		Wilhelminapark 36</br>
																		5041 EC Tilburg
																	</a>
																</p>
																<p>
																	Tel: +31 (0)13 460 92 80<br>
																	Fax: +31 (0)13 460 92 81<br>
																	Email: <a href="mailto:info@cabman.nl" target="_blank">info@cabman.nl</a>
																</p>
															<?php } ?>
															<?php if ($order_billing_country == 'DE') { ?>
																<p>Cabman Shop</p>
																<p>Euphoria Software BV<br>
																	<a href="https://www.google.com/url?q=https://maps.google.com/?q%3DWilhelminapark%2B36%2B5041%2BEC%2BTilburg%26entry%3Dgmail%26source%3Dg&amp;source=gmail&amp;ust=1518533252238000&amp;usg=AFQjCNHvvZELbYejUTQoatSaRBPMw9A_iw">
																		Wilhelminapark 36</br>
																		5041 EC Tilburg, die Niederlande.
																	</a>
																</p>
																<p>
																	Telefon: 0049-4087409636<br>
																	E-mail-Adresse: <a href="mailto:info@cabman.de" target="_blank">info@cabman.de</a>
																</p>
															<?php } ?>
															<?php //echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
