<?php /* #?ini charset="utf-8"? */

[ModuleSettings]
ExtensionRepositories[]=jaj_newsletter
ModuleList[]=jaj_newsletter

[Leftmenu_jaj_newsletter]
Name=dashboard
Links[]
LinkNames[]
Links[change_password]=user/password
PolicyList_change_password[]=user/password

Links[collaboration]=collaboration/view/summary
PolicyList_collaboration[]=collaboration/view

Links[dashboard]=content/dashboard

Links[edit_profile]=user/edit/(action)/edit
PolicyList_edit_profile[]=user/selfedit

Links[my_bookmarks]=content/bookmark
PolicyList_my_bookmarks[]=content/bookmark

Links[my_drafts]=content/draft
PolicyList_my_drafts[]=content/edit

Links[my_notifications]=notification/settings
PolicyList_my_notifications[]=notification/use

Links[my_pending]=content/pendinglist
PolicyList_my_pending[]=content/pendinglist


*/ ?>
