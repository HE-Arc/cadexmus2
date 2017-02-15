import $ from 'jquery'

import info_template from '../../views/projet/invite-info.hbs'
import img_template from '../../views/projet/userImg.hbs'

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
            if(data.user)
                this.addUserImage(data.user);
            this.info(data.status);
        }).catch((e) => {
            console.error(e)
        })
    }

    info(data) {
        var info = $(info_template({status: data}))
        this.elem.find('*[name=pseudo]').blur();
        info.appendTo(this.elem)
            .hide()
            .fadeIn(200, () => {
                info.delay(3000)
                    .fadeOut(1000, () => {
                        info.remove()
                    })
            })
    }

    addUserImage(user){
        this.elem.find('*[name=pseudo]').blur().val("");
        $("#container").prepend(
            $(img_template({
                name: user.name,
                color: user.color,
                path: user.path
            }))
        )
    }
}

module.exports = Invite
