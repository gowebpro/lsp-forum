{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.acp}</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.plugin_about}</h3>
	</header>

	<div class="forums-content">
		<section>{$aLang.plugin.forum.plugin_about_text}</section>
		<section>
			<header>{$aLang.plugin.forum.plugin_donate}</header>
			<dl class="form-item">
				<dt>
					<span class="fl-r"><i class="icon-ok"></i> <strong>WebMoney:</strong></span>
				</dt>
				<dd>
					<ul>
						<li>R114660092681</li>
						<li>Z775516332183</li>
						<li>E420622521130</li>
						<li>U177722554210</li>
					</ul>
				</dd>
			</dl>
			<dl class="form-item">
				<dt>
					<span class="fl-r"><i class="icon-ok"></i> <strong>Yandex Money:</strong></span>
				</dt>
				<dd>
					<ul>
						<li>41001703556446</li>
					</ul>
				</dd>
			</dl>
		</section>
	</div>
</div>

{include file='footer.tpl'}