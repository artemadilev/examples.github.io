$(document).ready(function () {
    let conditionForLine1 = 0;
    let conditionForLine2 = 1;
    buildLine(1, 28, '#floor2-line1', conditionForLine1);
    buildLine(1, 28, '#floor2-line2', conditionForLine2);
    buildLine(30, 57, '#floor3-line1', conditionForLine1);
    buildLine(30, 57, '#floor3-line2', conditionForLine2);
    buildLine(58, 85, '#floor4-line1', conditionForLine1);
    buildLine(58, 85, '#floor4-line2', conditionForLine2);
    buildLine(86, 115, '#floor5-line1', conditionForLine1);
    buildLine(86, 115, '#floor5-line2', conditionForLine2);
    buildLine(116, 143, '#floor6-line1', conditionForLine1);
    buildLine(116, 143, '#floor6-line2', conditionForLine2);

    function buildLine(firstRoom, countOfRooms, lineID, conditionForLine1) {
        for (let blockID = firstRoom; blockID <= countOfRooms; blockID++) {
            if (rooms[blockID].title % 2 === conditionForLine1) {
                $(lineID).append("<div class='box-wrapper'></div>");
                $('.box-wrapper:last').append("<div class='box'></div>");
                $('.box-wrapper:last').append("<div class='box-number'></div>");
                $('.box-wrapper:last .box-number').text(rooms[blockID].title);
                $('.box:last').attr('id', blockID).text('ПАЛАТА');
                let placeID = 1;
                let availablePlace = 0;
                let option = 1;
                let myClass = 'box-bed3';
                let roomsUpdate = 'roomsUpdate[' + blockID + ']';
                let countOfAvailable = 0;
                $('.box:last').append("" +
                    "<div class='box-bed'>" +
                    "<svg aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"bed\" class=\"svg-inline--fa fa-bed fa-w-20\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 640 512\"><path fill=\"#3379b5\" d=\"M176 256c44.11 0 80-35.89 80-80s-35.89-80-80-80-80 35.89-80 80 35.89 80 80 80zm352-128H304c-8.84 0-16 7.16-16 16v144H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v352c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16v-48h512v48c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V240c0-61.86-50.14-112-112-112z\"></path></svg>" +
                    "</div>");
                $('.box-bed:last').addClass(myClass);
                $('<select class="selectCount"></select>').appendTo('.box-bed:last');
                $('.selectCount:last').attr('name', roomsUpdate);
                while (placeID <= places[blockID].length) {
                    let optionClass = 'option' + option;
                    if (placeID === 1) {
                        $('.selectCount:last').append("<option class='option'></option>");
                        $('option:last').text(0).val(0);
                    }
                    if (places[blockID][placeID - 1].is_available === 1) {
                        availablePlace++;
                    }
                    if (places[blockID][placeID - 1].used === 1) {
                        $('.box:last').addClass('room-busy');
                        if (rooms[blockID].is_booked === 1) {
                            $('.box:last').removeClass('room-busy');
                        }
                        if (places[blockID][placeID - 1].is_available === 1) {
                            countOfAvailable++; /** Счетчик для отображения в селекте количества доступных мест с учетом проживающих */
                        }
                        $('.selectCount:last .option').remove();
                    }
                    if (placeID === places[blockID].length) {
                        $('.selectCount:last').append("<option></option>");
                        $('option:last').text(placeID).val(placeID);
                        $('option:last').addClass(optionClass);
                        $('.selectCount:last [value=' + availablePlace + ']').prop('selected', true);
                        for (let s = 1; s < countOfAvailable; s++) {
                            $('.selectCount:last .option' + s).remove();
                        }
                    } else {
                        $('.selectCount:last').append("<option></option>");
                        $('option:last').text(placeID).val(placeID);
                        $('option:last').addClass(optionClass);
                    }
                    placeID++;
                    option++;
                }
                if (rooms[blockID].is_booked === 1) {
                    $('.box:last').addClass('booked');
                }
                if (rooms[blockID].id === 43 || rooms[blockID].id === 45) {
                    $('.box#' + rooms[blockID].id + '').addClass('cabinet-empty unavailable');
                    $('.box#43').addClass('cabinet-empty-wrapper');
                    $('.box#' + rooms[blockID].id + ' .box-bed').hide();
                    $('.box#' + rooms[blockID].id + ' .selectCount').hide();
                }
                if (rooms[blockID].title === '532') {
                    $(lineID).append("<div class='box-wrapper'></div>");
                    $('.box-wrapper:last').append("<div class='box--not-room'><span></span></div>");
                    $('.box-wrapper:last').append("<div class='box-number'>&nbsp;</div>");
                    $(lineID).append("<div class='box-wrapper'></div>");
                    $('.box-wrapper:last').append("<div class='box--not-room viewing'><span></span></div>");
                    $('.box-wrapper:last').append("<div class='box-number'>&nbsp;</div>");
                }
                if (rooms[blockID].title === '215') {
                    $(lineID).append("<div class='box-wrapper--not-room hall'></div>");
                    $('.hall:last').append("<div class='box--not-room'><span>ХОЛЛ</span></div>");
                    $('.hall:last').append("<div class='box-number'>&nbsp;</div>");
                }
                if (rooms[blockID].title === '227') {
                    $(lineID).append("<div class='box-wrapper--not-room cabinet'></div>");
                    $('.cabinet:last').append("<div class='box--not-room'><span>Кабинет</span></div>");
                    $('.cabinet:last').append("<div class='box-number'>&nbsp;</div>");
                }
                if (rooms[blockID].id === 30 || rooms[blockID].id === 32) {
                    $('.box#' + rooms[blockID].id + '').addClass('cabinet-science unavailable');
                    $('.box#30').addClass('cabinet-science-wrapper');
                    $('.box#' + rooms[blockID].id + ' .box-bed').hide();
                    $('.box#' + rooms[blockID].id + ' .selectCount').hide();
                }
                if (rooms[blockID].id === 46 || rooms[blockID].id === 48) {
                    $('.box#' + rooms[blockID].id + '').addClass('cabinet-psycho unavailable');
                    $('.box#46').addClass('cabinet-psycho-wrapper');
                    $('.box#' + rooms[blockID].id + ' .box-bed').hide();
                    $('.box#' + rooms[blockID].id + ' .selectCount').hide();
                }
                if (rooms[blockID].title === '315') {
                    $(lineID).append("<div class='box-wrapper--not-room hall'></div>");
                    $('.hall:last').append("<div class='box--not-room'><span>ХОЛЛ</span></div>");
                    $('.hall:last').append("<div class='box-number'>&nbsp;</div>");
                }
            }
        }
    }

    $('#bookedHistory').hide();

    $(".box:not(.unavailable)").click(function () {
        $('#bookedHistory').hide();
        if ($(this).hasClass('selected-item')) {
            $('.box-wrapper').find('.selected-item').removeClass('selected-item');
            $('#selectedRoom').attr('value', null);
            $('.box-wrapper .booking').remove();
            $('.bookedHistory-body').empty();
            $('#bookedHistory').hide();
        } else {
            $('.box-wrapper .booking').remove();
            $('.box-wrapper').find('.selected-item').removeClass('selected-item');
            $(this).addClass('selected-item');
            let comment = '';
            let planDateStart = '';
            let planDateEnd = '';
            if (typeof roomsBooking[this.id] !== 'undefined') {
                comment = roomsBooking[this.id].comment;
                planDateStart = roomsBooking[this.id]['plan_date_start'];
                planDateEnd = roomsBooking[this.id]['plan_date_end'];
            }
            $(this).parent().append("<div class='booking'>" +
                "<form method='post' id='form-tobook' class='form-horizontal' action='/dashboard/habitation/tobook'>" +
                "<input type='hidden' name='selectedRoom' id='selectedRoom'>" +
                "<p>Период бронирования</p>" +
                "</form>" +
                "</div>");
            if (rooms[this.id].is_booked) {
                $('.booking form:last').append(
                    "<div class='start-wrapper'>" +
                    "<label for='plan_date_start' class='label-date'>С</label>" +
                    "<input type='text' id='plan_date_start' name='plan_date_start' class='datepicker'></div>" +
                    "<label for='plan_date_end' class='label-date'>По</label>" +
                    "<input type='text' id='plan_date_end' name='plan_date_end' class='datepicker'><br>" +
                    "<label for='plan-date-comment'>Комментарий</label>" +
                    "<textarea id='plan-date-comment' name='plan-date-comment' rows='3' class='form-control'>" + comment + "</textarea>" +
                    "<div class='booking-btn-wrapper'>" +
                    "<button type='submit' name='toCancelBooking' class='btn btn-success'>Снять бронь</button>" +
                    "<button type='submit' name='booking-edit' class='btn btn-success'>Редактировать</button>" +
                    "</div>"
                );
                $('#plan_date_start').inputmask("99.99.9999").attr('placeholder', 'дд.мм.гггг');
                $('#plan_date_end').inputmask("99.99.9999").attr('placeholder', 'дд.мм.гггг');
                $('#plan_date_start').val(planDateStart);
                $('#plan_date_end').val(planDateEnd);
            } else {
                $('.booking form:last').append(
                    "<div class='start-wrapper'>" +
                    "<label for='plan_date_start' class='label-date'>С</label>" +
                    "<input type='text' id='plan_date_start' name='plan_date_start' class='datepicker'></div>" +
                    "<label for='plan_date_end' class='label-date'>По</label>" +
                    "<input type='date' id='plan_date_end' name='plan_date_end' class='form-control' style='padding: 4px;'><br>" +
                    "<label for='plan-date-comment'>Комментарий</label>" +
                    "<textarea id='plan-date-comment' name='plan-date-comment' rows='3' class='form-control'></textarea>" +
                    "<div class='booking-btn-wrapper'>" +
                    "<button type='submit' class='btn btn-success'>Забронировать</button>" +
                    "</div>"
                );
                $('#plan_date_start').inputmask("99.99.9999").attr('placeholder', 'дд.мм.гггг');
                if (lastDateEnd[this.id]) {
                    $('#plan_date_start').val(lastDateEnd[this.id]).text(lastDateEnd[this.id]);
                }
            }
            let selectedRoom = this.id;
            $('#selectedRoom').attr('value', selectedRoom);
            $('.booking').show();
            if (typeof roomsBookingAll[this.id] !== 'undefined' && roomsBookingAll[this.id].length > 0) {
                $('#bookedHistory').show();
                $('.bookedHistory-body').empty();
                for (let i = 0; i < 10; i++) {
                    if (typeof roomsBookingAll[this.id][i] !== 'undefined') {
                        $('.bookedHistory-body').append('<tr></tr>');
                        $('tr:last').append('<td>' + (i + 1) + '</td>');
                        $('tr:last').append('<td>' + roomsBookingAll[this.id][i].title + '</td>');
                        $('tr:last').append('<td>' + roomsBookingAll[this.id][i].created_at + '</td>');
                        $('tr:last').append('<td>' + roomsBookingAll[this.id][i].type_of_action + '</td>');
                        $('tr:last').append('<td>' + roomsBookingAll[this.id][i].comment + '</td>');
                        $('tr:last').append('<td>' + roomsBookingAll[this.id][i].user_id + '</td>');
                        $('tr:last').append('<td>с ' + roomsBookingAll[this.id][i].plan_date_start + ' по ' + roomsBookingAll[this.id][i].plan_date_end + '</td>');
                    }
                }
            }
        }
    });
});