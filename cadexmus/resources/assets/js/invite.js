import $ from 'jquery'

import template from '../../views/projet/invite-info.hbs'

class Invite {
    constructor(elementOrSelector) {
        this.elem = $($(elementOrSelector)[0])
        this.asGuest = ["false", false, "0", 0, ""].indexOf(this.elem.data('as-guest')) === -1
        this.url = this.elem.find('form').attr('action')
        if (!this.url) {
            console.error('Invite element should have a form with an action.')
        }

        this.elem.on('submit', this.onSubmit.bind(this))
    }

    onSubmit(event) {
        event.preventDefault()

        var userToInvite = this.elem.find('*[name=pseudo]').val()
        if (!userToInvite) {
            return
        }

        if (this.asGuest) {
            alert("you are not in the project, you can't invite")
            return
        }

        $.ajax({
            url: this.url,
            type: 'POST',
            data: { userToInvite: userToInvite }
        }).then((data) => {
            this.info(data)
        }).catch((e) => {
            console.error(e)
        })
    }

    info(data) {
        var info = $(template({status: data}))
        info.appendTo(this.elem)
            .hide()
            .fadeIn(200, () => {
                info.delay(3000)
                    .fadeOut(1000, () => {
                        info.remove()
                    })
            })
    }
}

module.exports = Invite
