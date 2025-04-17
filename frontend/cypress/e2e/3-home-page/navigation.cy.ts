context('Home', () => {
    beforeEach(() => {
        cy.login()
        cy.visit('/')
    })

    describe('Navigation', () => {
        it('Navigates to listing', () => {
            cy.get('[data-cy="/listing"]').should('contain', 'Listing').click()
            cy.url().should('include', '/listing')
        })

        it('Navigates to tags', () => {
            cy.get('[data-cy="/tags"]').should('contain', 'Tags').click()
            cy.url().should('include', '/tags')
        })

        it('Navigates to FAQ page', () => {
            cy.get('[data-cy="/faq"]').should('contain', 'FAQ').click()
            cy.url().should('include', '/faq')
        })

        it('Navigates to contact page', () => {
            cy.get('[data-cy="/contact"]').should('contain', 'Contact').click()
            cy.url().should('include', '/contact')
        })

        it('Navigates to invitation page', () => {
            cy.get('[data-cy="/invite"]').should('contain', 'Invite people').click()
            cy.url().should('include', '/invite')
        })
    })
})
