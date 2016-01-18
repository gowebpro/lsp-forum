{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.acp}</h2>

{include file="$sTemplatePathForum/menu.forum.admin.tpl"}

<div class="forums">
	<div class="fBox forum-acp">
		<header class="forums-header">
			<h3>{$aLang.plugin.forum.plugin_about}</h3>
		</header>

		<div class="forums-content">
			<div class="fContainer">
				<section>
					{$aLang.plugin.forum.plugin_about_text}
				</section>
				<section>
					<header>
						<h3>{$aLang.plugin.forum.plugin_donate}</h3>
					</header>
					<div class="clearfix">
						<div class="fl-r">
							<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?account=41001703556446&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=%D0%9D%D0%B0+%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B0&default-sum=100&button-text=03&successURL=" width="450" height="200"></iframe>
						</div>
						<div class="fl-l">
							<dl class="form-item webmoney">
								<dt>
									<span class="fl-r"><i class="icon-ok"></i> <strong>WebMoney:</strong></span>
								</dt>
								<dd>
									<ul>
										<li><img src="http://www.webmoney.ru/img/icons/wmr_32.png" alt="WMR" /> R114660092681</li>
										<li><img src="http://www.webmoney.ru/img/icons/wmz_32.png" alt="WMZ" /> Z775516332183</li>
										<li><img src="http://www.webmoney.ru/img/icons/wme_32.png" alt="WME" /> E420622521130</li>
										<li><img src="http://www.webmoney.ru/img/icons/wmu_32.png" alt="WMU" /> U177722554210</li>
									</ul>
								</dd>
							</dl>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

{include file='footer.tpl'}