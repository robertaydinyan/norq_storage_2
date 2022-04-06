"use strict";
function drawExecutorAndObservers(employees, container, isCompleted, isExecutor) {
    if (employees && employees.length) {
        employees.forEach((emp) => {
            container.append(templatesGenerationCheckListItemContainer({
                item_get: "get-tt-checklist-list-employees",
                id: emp.id,
                link: emp.link,
                action: emp.action,
                name: emp.full_name,
                executor: isExecutor,
                completed: isCompleted,
            }));
        });
        container.css("display", "flex");
    } else {
        container.css("display", "none");
    }
}
function showHideByClickingChecklistItem(not_target) {
    not_target.removeClass("checklist-task-under-construction");
    not_target.find(".z-ea-ch-add-empty-point-value").hide();
    not_target.find(".tch-ied-popup").hide();
    not_target.find(".checklist-responsibles-name-del").hide();
    not_target.find(".z-ea-ch-add-name-input").prop('readonly', true);
}
