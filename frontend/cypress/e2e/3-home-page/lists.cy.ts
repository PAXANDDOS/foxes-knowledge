context('Home', () => {
    beforeEach(() => {
        cy.login()
        cy.visit('/')
    })

    describe('Top tags', () => {
        const tagsRegExp = /^https?:\/\/(localhost|127\.0\.0\.1)(:\d{4})?\/tags$/
        const tagRegExp = /^https?:\/\/(localhost|127\.0\.0\.1)(:\d{4})?\/tags\/\w+$/

        beforeEach(() => {
            cy.get('*[class^="topTagsList"]').then($top => cy.wrap($top).as('top'))
        })

        it('Navigates to all tags', () => {
            cy.get('@top').find('a').contains('See all').click()
            cy.url().should('match', tagsRegExp)
        })

        it('Navigates to tag', () => {
            cy.get('@top').find('*[class^="topTagsList_content"]').find('a').first().click()
            cy.url().should('match', tagRegExp)
        })
    })
})
