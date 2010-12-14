	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{'Manage Newsletter Settings'|i18n( 'design/admin/jaj_newsletter/settings')|wash}</h1>
			<div class="header-mainline"></div>
		</div>
		<h2>1. Database setup</h2>
		<p>
			{if $setup.database_ok}
				Database looks ok
			{else}
				Database does not contain tables for extension.<br />
				Please run the following from website root:
<pre>
mysql -u (database user) -p (database) < extension/jaj_newsletter/sql/mysql/schema.sql
</pre>
			{/if}
		</p>
		
		<h2>2. Content Classes</h2>
		<p>
			{if $setup.content_classes_ok}
				Content classes looks ok
			{else}
				Content class for newsletter is missing.<br />
				Please import packages from: extension/jaj_newsletter/packages
			{/if}
		</p>
		
		<h2>3. INI Settings</h2>
		<p>
			{if and( $setup.newsletter_folder_ok, $setup.newsletter_settings_ok)}
				INI Settings looks ok. <br />
			{else}
				{if not( $setup.newsletter_folder_ok )}
				Newsletter folder is not set.<br />
				{/if}
				Please edit <i>jaj_newsletter.ini.append.php</i>:
<pre>
[NewsletterSettings]
RootFolderNodeId=
FromEmail=
FromName=
ReplyEmail=
</pre>
			{/if}
		</p>
		
		<h2>4. Newsletter section</h2>
		<p>
		{if $setup.newsletter_section_ok}
			Section for newsletter looks ok
		{else}
			Section for newsletter is missing.<br />
			Please create an section with identifier: <i>jaj_newsletter</i> and assign it to the newsletter folder.
		{/if}
		</p>
		
		<h2>5. Roles and rights</h2>
		<p>
		{if $setup.newsletter_sub_access_ok}
			Access settings looks ok.
		{else}
			Please ensure that <i>Anonymous</i> has the following rights:
			<table class="list">
			<tr>
				<th>Module</th>
				<th>Function</th>
				<th>Limit</th>
			</tr>
			<tr>
				<td>jaj_newsletter</td>
				<td>manage_subscription</td>
				<td></td>
			</tr>
			<tr>
				<td>content</td>
				<td>read</td>
				<td>Class( Newsletter ), Section( JAJ Newsletter )</td>
			</tr>
			</table>
		{/if}
		</p>
		
		<h2>6. Premailer</h2>
		<p>
			Please ensure that premailer is installed and can be run
		</p>
		
		<h2>7. Email settings</h2>
		<p>
			Please ensure that email settings are correct
		</p>
	</div>