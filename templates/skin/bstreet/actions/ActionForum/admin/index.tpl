{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div id="filter-top">
	<div class="filter-bg"></div>

	<h2 class="page-header" style="background:none">{$aLang.plugin.forum.acp}</h2>
</div>
<br /><br />
<div class="wrapper-content">
	<div class="mb-30">
		{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}
	</div>
	<div class="forums">
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
</div>

{include file='footer.tpl'}