{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.acp}</h2>

{include file="$sTemplatePathForum/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.plugin_about}</h3>
	</header>

	<div class="forums-content">
		<section>
			{$aLang.plugin.forum.plugin_about_text}
		</section>
		<section>
			<header>
				<h3>{$aLang.plugin.forum.plugin_donate}</h3>
			</header>
			<dl class="form-item donate">
				<dt>
					<span class="fl-r"><strong>WebMoney:</strong></span>
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
			<dl class="form-item donate">
				<dt>
					<span class="fl-r"><strong>Yandex Money:</strong></span>
				</dt>
				<dd>
					<ul>
						<li><img src="{$aTemplateWebPathPlugin['forum']}icons/yandex.png" alt="Yandex.Money"> 41001703556446</li>
					</ul>
				</dd>
			</dl>
		</section>
	</div>
</div>

{include file='footer.tpl'}