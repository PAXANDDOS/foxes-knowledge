context('Guest', () => {
    describe('Test guest page', () => {
        beforeEach(() => {
            cy.visit('/')
            cy.url().should('include', '/guest')
        })

        it('Displays title', () => {
            cy.get('h1').first().should('have.text', 'Foxes / Knowledge')
        })

        it('Redirects to auth', () => {
            cy.get('a').first().should('have.text', 'Sign in').click()
            cy.url().should('include', '/signin')
        })
    })
})
