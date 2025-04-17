context('Authentication', () => {
    describe('Test sign in page', () => {
        beforeEach(() => {
            cy.visit('/signin')
        })

        it('Submit wrong email', () => {
            cy.get('[data-cy="email"]').type('example@example.com')
            cy.get('[data-cy="password"]').type('123456789')
            cy.get('form').submit()
            cy.get('[data-cy="toaster"]').should('contain', 'The selected email is invalid.')
        })

        it('Submit wrong password', () => {
            cy.get('[data-cy="email"]').type('pashalitovka@gmail.com')
            cy.get('[data-cy="password"]').type('1234567890')
            cy.get('form').submit()
            cy.get('[data-cy="toaster"]').should('contain', 'Invalid login credentials.')
        })

        it('Submit data successfully', () => {
            cy.session('user', () => {
                cy.visit('/signin')
                cy.get('[data-cy="email"]').type('pashalitovka@gmail.com')
                cy.get('[data-cy="password"]').type('123456789')
                cy.get('form').submit()
                cy.get('[data-cy="toaster"]').should('contain', 'Signed in successfully.')
            })
        })
    })
})
