import './commands'

Cypress.Commands.add('login', (userType = 'main') => {
    const user = {
        main: {
            email: 'pashalitovka@gmail.com',
            password: '123456789',
        },
        secondary: {
            email: 'navwie@gmail.com',
            password: '123456789',
        },
    }[userType]

    cy.session(
        [user.email, user.password],
        () => {
            cy.visit('/signin')
            cy.get('[data-cy="email"]').type(user.email)
            cy.get('[data-cy="password"]').type(user.password)
            cy.get('form').submit()
            cy.get('[data-cy="toaster"]').should('contain', 'Signed in successfully.')
        },
        {
            validate() {
                cy.request('/api/me').its('status').should('eq', 200)
            },
        }
    )
})

declare global {
    namespace Cypress {
        interface Chainable {
            /**
             * Login as a user
             * @param userType - The user type to login as
             * @example cy.login('main')
             **/
            login(userType?: 'main' | 'secondary'): Chainable<Element>
        }
    }
}
