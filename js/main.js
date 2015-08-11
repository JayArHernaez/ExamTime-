$(document).ready(function(){
	
	$("#addStudent").click(function(){
		$("#addStudent-modal").modal('show');
	});
	$("#addGroup").click(function(){
		$("#addGroup-modal").modal('show');
	});

	$("#login").click(function(){
		$("#login-modal").modal('show');
		$("#login-uname").focus();
	});
	
	$("#leavegrp-btn").click(function(){
		$("#leaveGroup-modal").modal('show');
	});


	$("#deleteStudent").click(function(){
		$("#deleteStudent-modal").modal('show');
	});

	$("#start_ex").click(function(){
		$("#submit-exam-btn").removeAttr("disabled");
	});
	
	$("#signup").click(function(){
		$("#signup-modal").modal('show');
	});

	$("#editexam").click(function(){
		$("#saveexam").removeAttr("disabled");
	});	

	$("#reg-acct").change(function(){
            $( "select option:selected").each(function(){
                if($(this).attr("value")=="Instructor"){
                	$("#student-input").hide();
                    $("#emp-input").show();
                }
                if($(this).attr("value")=="Student"){
                    $("#emp-input").hide();
                    $("#student-input").show();
                }
                
            });
    }).change();
    $("#editProf").click(function(){
		$("#firstname").removeAttr("disabled");
		$("#lastname").removeAttr("disabled");
		$("#username").removeAttr("disabled");
		$("#newPassword").removeAttr("disabled");
		$("#currPassword").removeAttr("disabled");
		$("#email").removeAttr("disabled");
		$("#savebtn").removeAttr("disabled");
	});
	
	$("#editProfile").click(function(){
		$("#firstname").removeAttr("disabled");
		$("#lastname").removeAttr("disabled");
		$("#username").removeAttr("disabled");
		$("#newPassword").removeAttr("disabled");
		$("#currPassword").removeAttr("disabled");
		$("#email").removeAttr("disabled");
		$("#profpic").removeAttr("disabled");
		$("#savebtn").removeAttr("disabled");
	});

	var q_count=2;
	$("#addQuestion-btn").click(function(){
		$(".question-group").append('<br><div class="input-group"><span class="input-group-addon">Q'+q_count+'</span><input name="question[]" id="" type="text" class="form-control"/></div><div class="input-group"><span class="input-group-addon">Answer</span><input name="answer[]" id="" type="text" class="form-control"/></div><div class="input-group"><span class="input-group-addon">Other Choices</span><input name="choicea[]" id="" type="text" class="form-control"/><input name="choiceb[]" id="" type="text" class="form-control"/><input name="choicec[]" id="" type="text" class="form-control"/></div>');
		q_count++;
	});

	$("#editexam").click(function(){
		$("#examname").removeAttr("disabled");
		$("#examdate").removeAttr("disabled");
		$("#examtakes").removeAttr("disabled");
		$("#examtime").removeAttr("disabled");
		$("#addQuestion-btn").removeAttr("disabled");
		$('input[name="question[]"]').each(function(){
			$(this).removeAttr('readonly');
		});
		$('input[name="answer[]"]').each(function(){
			$(this).removeAttr('readonly');
		});
		$('input[name="choicea[]"]').each(function(){
			$(this).removeAttr('readonly');
		});
		$('input[name="choiceb[]"]').each(function(){
			$(this).removeAttr('readonly');
		});
		$('input[name="choicec[]"]').each(function(){
			$(this).removeAttr('readonly');
		});
	});
});
 