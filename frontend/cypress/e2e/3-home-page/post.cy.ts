context('Home', () => {
    beforeEach(() => {
        cy.login()
        cy.visit('/')
    })

    describe('Post', () => {
        const postRegExp = /^https?:\/\/(localhost|127\.0\.0\.1)(:\d{4})?\/u\/\w+\/\d+$/
        const userRegExp = /^https?:\/\/(localhost|127\.0\.0\.1)(:\d{4})?\/u\/\w+$/
        const tagRegExp = /^https?:\/\/(localhost|127\.0\.0\.1)(:\d{4})?\/tags\/\w+$/

        beforeEach(() => {
            cy.get('article')
                .should('have.length.at.least', 1)
                .first()
                .then($post => cy.wrap($post).as('post'))
        })

        it('Navigates to post via title', () => {
            cy.get('@post').find('h1').click()
            cy.url().should('match', postRegExp)
        })

        it('Navigates to post via reaction', () => {
            cy.get('@post').find('*[class^="post_trackers"]').find('button').first().click()
            cy.url().should('match', postRegExp)
        })

        it('Navigates to post via comment', () => {
            cy.get('@post').find('*[class^="post_trackers"]').find('button').last().click()
            cy.url().should('match', postRegExp)
        })

        it('Navigates to author', () => {
            cy.get('@post').find('*[class^="post_authorBlock"]').click()
            cy.url().should('match', userRegExp)
        })

        it('Navigates to tag', () => {
            cy.get('@post').find('*[class^="post_tags"]').find('button').first().click()
            cy.url().should('match', tagRegExp)
        })
    })
})
