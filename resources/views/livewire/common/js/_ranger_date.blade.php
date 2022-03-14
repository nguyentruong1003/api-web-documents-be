<script>
    $("document").ready(function() {
        window.livewire.on('close-modal-create-research-plan', () => {
            document.getElementById('close-modal-create-research-plan').click()
        });
        window.addEventListener('run-select2-and-kendoDatepicker', (e) => {
            let start_date = null
            let end_date = null
            let start_date_2 = null
            let end_date_2 = null
            if (e.detail.mainMisionStartDate) {
                start_date = new Date(e.detail.mainMisionStartDate);
            }
            if (e.detail.mainMisionEndDate) {
                end_date = new Date(e.detail.mainMisionEndDate);
            }
            if (e.detail.childrenMissionStartDate) {
                start_date_2 = new Date(e.detail.childrenMissionStartDate);
            }
            if (e.detail.childrenMissionEndDate) {
                end_date_2 = new Date(e.detail.childrenMissionEndDate);
                console.log(end_date_2);
            }


            $('#start_date').kendoDatePicker({
                animation: {
                    open: {
                        effects: "zoom:in",
                        duration: 300
                    },
                    close: {
                        effects: "zoom:out",
                        duration: 300
                    }
                },
                format: 'dd-MM-yyyy',
                type: 'number',
                value: start_date,
                max: new Date(2199, 11, 31),
                change: function() {
                    window.livewire.emit('set-start-date', {
                        'start-date': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                    });
                }
            });
            $('#end_date').kendoDatePicker({
                animation: {
                    open: {
                        effects: "zoom:in",
                        duration: 300
                    },
                    close: {
                        effects: "zoom:out",
                        duration: 300
                    }
                },
                format: 'dd-MM-yyyy',
                type: 'number',
                value: end_date,
                max: new Date(2199, 11, 31),
                change: function() {
                    window.livewire.emit('set-end-date', {
                        'end-date': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                    });
                }
            });
            $('#start_date_2').kendoDatePicker({
                animation: {
                    open: {
                        effects: "zoom:in",
                        duration: 300
                    },
                    close: {
                        effects: "zoom:out",
                        duration: 300
                    }
                },
                format: 'dd-MM-yyyy',
                type: 'number',
                value: start_date_2,
                max: new Date(2199, 11, 31),
                change: function() {
                    window.livewire.emit('set-start-date-children', {
                        'start-date-2': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                    });
                }
            });
            $('#end_date_2').kendoDatePicker({
                animation: {
                    open: {
                        effects: "zoom:in",
                        duration: 300
                    },
                    close: {
                        effects: "zoom:out",
                        duration: 300
                    }
                },
                format: 'dd-MM-yyyy',
                type: 'number',
                value: end_date_2,
                max: new Date(2199, 11, 31),
                change: function() {
                    window.livewire.emit('set-end-date-children', {
                        'end-date-2': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                    });
                }
            });
        });
        $('#start_date').kendoDatePicker({
            animation: {
                open: {
                    effects: "zoom:in",
                    duration: 300
                },
                close: {
                    effects: "zoom:out",
                    duration: 300
                }
            },
            format: 'dd-MM-yyyy',
            type: 'number',
            max: new Date(2199, 11, 31),
            change: function() {
                window.livewire.emit('set-start-date', {
                    'start-date': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                });
            }
        });
        $('#end_date').kendoDatePicker({
            animation: {
                open: {
                    effects: "zoom:in",
                    duration: 300
                },
                close: {
                    effects: "zoom:out",
                    duration: 300
                }
            },
            format: 'dd-MM-yyyy',
            type: 'number',
            max: new Date(2199, 11, 31),
            change: function() {
                window.livewire.emit('set-end-date', {
                    'end-date': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                });
            }
        });
        $('#start_date_2').kendoDatePicker({
            animation: {
                open: {
                    effects: "zoom:in",
                    duration: 300
                },
                close: {
                    effects: "zoom:out",
                    duration: 300
                }
            },
            format: 'dd-MM-yyyy',
            type: 'number',
            max: new Date(2199, 11, 31),
            change: function() {
                window.livewire.emit('set-start-date-children', {
                    'start-date-2': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                });
            }
        });
        $('#end_date_2').kendoDatePicker({
            animation: {
                open: {
                    effects: "zoom:in",
                    duration: 300
                },
                close: {
                    effects: "zoom:out",
                    duration: 300
                }
            },
            format: 'dd-MM-yyyy',
            type: 'number',
            max: new Date(2199, 11, 31),
            change: function() {
                window.livewire.emit('set-end-date-children', {
                    'end-date-2': this.value() ? this.value().toLocaleDateString() : new Date().toLocaleDateString()
                });
            }
        });
        $('input[name="start_date"]').on('apply.daterangepicker', function(ev, picker) {
            var startDate = (picker.searchStartDate.format('YYYY/MM/DD'));
            var endDate = (picker.searchEndDate.format('YYYY/MM/DD'));
            $(this).val(startDate, endDate);
            $('input[name="start_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('input[name="end_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
        document.addEventListener('livewire:load', function() {
            $(function() {
                $('#start_date').on('change', (e) => {
                    window.livewire.emit('searchStartTime',
                        document.getElementById('start_date').value,
                    );
                });
                $('#end_date').on('change', (e) => {
                    window.livewire.emit('searchEndTime',
                        document.getElementById('end_date').value,
                    );
                });
                $('#start_date_2').on('change', (e) => {
                    window.livewire.emit('searchStartTime2',
                        document.getElementById('start_date_2').value,
                    );
                });
                $('#end_date_2').on('change', (e) => {
                    window.livewire.emit('searchEndTime2',
                        document.getElementById('end_date_2').value,
                    );
                });
                // truyền dữ liệu để tạo mới 
                $('#btn_save_research_plan').on('click', e => {
                    window.livewire.emit('store_research_mission',
                        $("#start_date").val(),
                        $("#end_date").val(),
                    );
                })
                $('#btn_save_research_plan_children').on('click', e => {
                    window.livewire.emit('store_research_children_mission',
                        $("#start_date_2").val(),
                        $("#end_date_2").val(),
                    );
                })
            });
        });

    });
</script>