import style from './navigation.module.scss'
import { NavigationItem } from './NavigationItem'

export const NavigationBar: React.FC = () => (
    <nav className={style.navigation}>
        <ul>
            <NavigationItem to="/" emoji="🏡" label="Home" />
            <NavigationItem to="/listing" emoji="📜" label="Listing" />
            <NavigationItem to="/tags" emoji="🔖" label="Tags" />
            <NavigationItem to="/faq" emoji="📖" label="FAQ" />
            <NavigationItem to="/contact" emoji="📇" label="Contact" />
            <NavigationItem to="/invite" emoji="✉️" label="Invite people" />
        </ul>
    </nav>
)
